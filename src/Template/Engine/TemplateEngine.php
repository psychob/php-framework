<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Parser\Tokenizer\Tokenizer;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Template\Generic\Block\EmptyBlock;
    use PsychoB\Framework\Template\Generic\Block\RawHtmlBlock;
    use PsychoB\Framework\Template\TemplateBlockRepository;
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

        /**
         * TemplateEngine constructor.
         *
         * @param TemplateBlockRepository $blockRepository
         */
        public function __construct(TemplateBlockRepository $blockRepository)
        {
            $this->blockRepository = $blockRepository;

            $this->tokenizer = new Tokenizer();
            $this->tokenizer->addGroup('symbols', ['$', '}}', '{{'], SymbolToken::class, false);
            $this->tokenizer->addGroup('whitespace', [' ', "\t", "\r", "\n", "\v"], WhitespaceToken::class, true);
        }

        public function execute(string $content, array $variables = []): string
        {
            $blocks = $this->fetch($content);

            return $this->executeBlocks($blocks, $variables);
        }

        private function fetch(string $content): array
        {
            $ret = [];
            $startIt = $it = 0;

            while (($currentIt = Str::findFirstOf($content, '{{', $it)) !== false) {
                if ($startIt !== $currentIt) {
                    // we have raw text in front of our block
                    $ret[] = new RawHtmlBlock(Str::substr($content, $startIt, $currentIt - $startIt));
                }

                $it = $currentIt + 2;
                [$instruction, $it] = $this->fetchInstruction($content, $it);

                $ret[] = $instruction;

                $startIt = $it;
            }

            $rest = Str::substr($content, $startIt);
            if ($rest !== '') {
                $ret[] = new RawHtmlBlock($rest);
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

            return [new EmptyBlock(), $closeTag + 3];
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
                        return [new EmptyBlock(), $closeTag + 3];
                }

                $it = $closeTag;
            } while (true);

            Assert::unreachable();
        }

    }
