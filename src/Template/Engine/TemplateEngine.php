<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Parser\Tokenizer\Tokenizer;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Parser\Tokenizer\TokenStream;
    use PsychoB\Framework\Template\Generic\Block\EchoRawHtmlBlock;
    use PsychoB\Framework\Template\Generic\Block\NullBlock;
    use PsychoB\Framework\Template\Generic\Block\PrintVariableBlock;
    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\Generic\Builtin\Variable;
    use PsychoB\Framework\Template\TemplateBlockRepository;
    use PsychoB\Framework\Template\TemplateFilterRepository;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class TemplateEngine implements TemplateEngineInterface
    {
        use TemplateEngineExecutorTrait;

        private const SYMBOLS    = '.:"\'{}|';
        private const WHITESPACE = " \t\r\n\v";

        /** @var TemplateBlockRepository */
        protected $blockRepository;

        /** @var Tokenizer */
        protected $tokenizer;

        /**  @var TemplateFilterRepository */
        private $filterRepository;

        /**
         * TemplateEngine constructor.
         *
         * @param TemplateBlockRepository  $blockRepository
         * @param TemplateFilterRepository $filterRepository
         */
        public function __construct(TemplateBlockRepository $blockRepository,
            TemplateFilterRepository $filterRepository)
        {
            $this->blockRepository = $blockRepository;
            $this->filterRepository = $filterRepository;

            $this->tokenizer = new Tokenizer();
            $this->tokenizer->addGroup('symbols', ['$', '}}', '{{', '.', '|', ':', '?', '"', '=', '@'],
                SymbolToken::class, false);
            $this->tokenizer->addGroup('whitespace', [' ', "\t", "\r", "\n", "\v"], WhitespaceToken::class, true);
        }

        public function execute(string $content, array $variables = []): string
        {
            $blocks = $this->fetch($content);

            return $this->executeBlocks($blocks, $variables, $this->filterRepository);
        }

        private function fetch(string $content): array
        {
            $ret = [];
            $startIt = $it = 0;

            while ($it < Str::len($content) && ($currentIt = Str::findFirstOf($content, '{{', $it)) !== false) {
                if ($startIt !== $currentIt) {
                    // we have raw text in front of our block
                    $ret[] = new EchoRawHtmlBlock(Str::substr($content, $startIt, $currentIt - $startIt));
                }

                $it = $currentIt + 2;
                [$instruction, $it] = $this->fetchInstruction($content, $it);

                $ret[] = $instruction;

                $startIt = $it;
            }

            $rest = Str::substr($content, $startIt);
            if ($rest !== '') {
                $ret[] = new EchoRawHtmlBlock($rest);
            }

            return $ret;
        }

        private function fetchInstruction(string $content, int $startIt): array
        {
            // first we need to fetch first argument of this block, and then decide what to do with it
            // some special characters:
            // @ - app
            // $ - variable
            // * - comment
            // + - extended comment
            // any other character will start normal block, that we need to fetch to get information about

            // we don't need to have our instruction started with 0th character, we might have some whitespace there
            $it = $startIt;

            switch ($content[$it]) {
                case '*':
                    return $this->fetchSimpleCommentInstruction($content, $it);

                case '+':
                    return $this->fetchExtendedCommentInstruction($content, $it);

                default:
                    return $this->fetchExpression($content, $it);
            }
        }

        private function fetchSimpleCommentInstruction(string $content, int $startIt): array
        {
            $closeTag = Str::findFirst($content, '*}}', $startIt);

            return [new NullBlock(), $closeTag + 3];
        }

        private function fetchExtendedCommentInstruction(string $content, int $startIt): array
        {
            $it = $startIt;
            do {
                $closeTag = Str::findFirst($content, [
                    '{{+', '+}}',
                ], $it);

                switch (Str::substr($content, $closeTag, 3)) {
                    case '{{+':
                        [, $closeTag] = $this->fetchExtendedCommentInstruction($content, $closeTag + 3);
                        break;

                    case '+}}':
                        return [new NullBlock(), $closeTag + 3];
                }

                $it = $closeTag;
            } while (true);

            Assert::unreachable();
        }

        private function fetchExpression(string $content, int $startIt): array
        {
            $stream = $this->tokenizer->tokenize(Str::substr($content, $startIt));
            $instructions = [];
            $lastIt = 0;

            for ($stream->rewind(); $stream->valid(); $lastIt = $stream->current()->getEnd()) {
                $token = $stream->current();

                switch (get_class($token)) {
                    case SymbolToken::class:
                        switch ($token->getToken()) {
                            case '$':
                                $instructions[] = $this->fetchExpression_FullVariable($stream);
                                break 2;

                            case '}}':
                                break 3;

                            default:
                                Assert::unreachable();
                        }

                        break;

                    case WhitespaceToken::class:
                        $stream->next();
                        continue 2;

                    default:
                        return $this->fetchExpression_Block($stream);
                }
            }

            return [$this->fetchExpression_PrepareInstructions($instructions), $lastIt + $startIt];
        }

        private function fetchExpression_FullVariable(TokenStream $stream)
        {
            $names = [];
            $filters = [];

            do {
                if ($this->skipSymbolAndWhitespace($stream)) {
                    break;
                }

                $names[] = $stream->current()->getToken();

                if ($this->skipSymbolAndWhitespace($stream)) {
                    break;
                }
            } while (Validate::typeRequirements($stream->current(), SymbolToken::class, ['token' => '.']));

            while (Validate::typeRequirements($stream->current(), SymbolToken::class, ['token' => '|'])) {
                if ($this->skipSymbolAndWhitespace($stream)) {
                    break;
                }

                $func = $stream->current()->getToken();
                $args = [];

                if ($this->skipSymbolAndWhitespace($stream)) {
                    break;
                }

                $filters[] = ['name' => $func, 'args' => $args];
            }

            return new Variable($names, $filters);
        }

        private function skipSymbolAndWhitespace(TokenStream $stream): bool
        {
            $stream->next();
            if (!$stream->valid()) {
                return true;
            }

            if ($stream->current() instanceof WhitespaceToken) {
                $stream->next();

                if (!$stream->valid()) {
                    return true;
                }
            }

            return false;
        }

        private function fetchExpression_PrepareInstructions(array $instructions): BlockInterface
        {
            if (Arr::len($instructions) === 1) {
                switch (get_class($instructions[0])) {
                    case Variable::class:
                        return new PrintVariableBlock($instructions[0]);
                }
            }
        }

        private function fetchExpression_Block(TokenStream $stream): array
        {
            $block = $stream->current()->getToken();
            $class = $this->blockRepository->get($block);

            $perf = call_user_func([$class, 'getHeaderPreference']);
            Assert::enumOneOf($perf, [
                'BlockInterface::PREFERENCE_TOKENS' => BlockInterface::PREFERENCE_TOKENS,
                'BlockInterface::PREFERENCE_ARGUMENTS' => BlockInterface::PREFERENCE_ARGUMENTS,
            ]);

            switch ($perf) {
                case BlockInterface::PREFERENCE_ARGUMENTS:
                    return $this->fetchExpression_Block_Arguments($stream, $block);

                case BlockInterface::PREFERENCE_TOKENS:
                    return $this->fetchExpression_Block_Tokens($stream, $block);

                default:
                    Assert::unreachable();
            }
        }

        private function fetchExpression_Block_Arguments(TokenStream $stream, string $class): array
        {
            dump($stream->current());
        }

        private function fetchExpression_Block_Tokens(TokenStream $stream, string $block): array
        {
            $this->skipSymbolAndWhitespace($stream);
            $tokens = [];

            for (; $stream->valid();) {
                $token = $stream->current();

                if (Validate::typeRequirements($stream->current(), SymbolToken::class, ['token' => '}}'])) {
                    break;
                }

                $tokens[] = $token;
                $this->skipSymbolAndWhitespace($stream);
            }

            return [$this->blockRepository->resolve($block, [$tokens]), $stream->current()->getEnd()];
        }
    }