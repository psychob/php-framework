<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine\SimpleTemplate;

    use MongoDB\BSON\Symbol;
    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Parser\Tokenizer\Tokenizer;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\KeywordToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\StringToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Parser\Tokenizer\Transformers\MergeIntoStringTransformer;
    use PsychoB\Framework\Template\Engine\TemplateEngineInterface;
    use PsychoB\Framework\Template\Generic\Block\EchoRawHtmlBlock;
    use PsychoB\Framework\Template\Generic\Block\NullBlock;
    use PsychoB\Framework\Template\Generic\Block\PrintConstantBlock;
    use PsychoB\Framework\Template\Generic\Block\PrintExpressionBlock;
    use PsychoB\Framework\Template\Generic\Block\PrintVariableBlock;
    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\Generic\Builtin\Constant;
    use PsychoB\Framework\Template\Generic\Builtin\Group;
    use PsychoB\Framework\Template\Generic\Builtin\Tree;
    use PsychoB\Framework\Template\Generic\Builtin\Variable;
    use PsychoB\Framework\Template\TemplateBlockRepository;
    use PsychoB\Framework\Template\TemplateFilterRepository;
    use PsychoB\Framework\Template\TemplateState;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class SimpleTemplateEngine implements TemplateEngineInterface
    {
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
            $this->tokenizer->addGroup('symbols', ['$', '}}', '{{', '.', '|', ':', '?', '"', '=', '@',
                '+', '-', '*', '/', '(', ')'], SymbolToken::class, false);
            $this->tokenizer->addGroup('keywords', ['true', 'false'], KeywordToken::class, false);
            $this->tokenizer->addGroup('whitespace', [' ', "\t", "\r", "\n", "\v"], WhitespaceToken::class, true);
            $this->tokenizer->addTransformer(MergeIntoStringTransformer::class);
        }

        public function execute(string $content, array $variables = []): string
        {
            $tree = [];
            $contentLen = Str::len($content);

            for ($it = 0; $it < $contentLen;) {
                $nextBracket = Str::findFirst($content, '{{', $it);

                if ($nextBracket === false) {
                    // no more bracket in source file, it's not a problem because we are at 0 level
                    break;
                } else {
                    $tree[] = new EchoRawHtmlBlock(Str::substr($content, $it, $nextBracket - $it));
                    $it = $nextBracket;
                }

                [$block, $it] = $this->parseBlock($content, $it + 2, NULL, NULL);
                $tree[] = $block;
            }

            if ($it < $contentLen) {
                $tree[] = new EchoRawHtmlBlock(Str::substr($content, $it));
            }

            return $this->executeTree($tree, $variables);
        }

        protected function parseBlock(string $content, int $startIt, ?string $blockName, ?string $endBlockName): array
        {
            $it = $startIt;
            switch ($content[$it]) {
                case '*':
                    return $this->parseCommentBlock($content, $startIt);

                case '+':
                    return $this->parseExtendedCommentBlock($content, $startIt);
            }

            $it = $this->skipWhitespace($content, $it);

            $tokens = [];
            foreach ($this->tokenizer->tokenize(Str::substr($content, $it)) as $token) {
                if (Validate::typeRequirements($token, SymbolToken::class, [
                    'token' => '}}',
                ])) {
                    break;
                }

                $tokens[] = $token;
            }

            [$isExpression, $instructions] = $this->interpretTokens($tokens, $it);

            if ($isExpression) {
                return [$this->prepareInstructions($instructions), Arr::last($tokens)->getEnd() + $it + 2];
            }

            dump([$isExpression, $instructions]);
        }

        private function executeTree(array $tree, array $var): string
        {
            $ret = '';
            $state = new TemplateState($var, $this->filterRepository);

            /** @var BlockInterface $node */
            foreach ($tree as $node) {
                $ret .= $node->execute($state);
            }

            return $ret;
        }

        private function parseCommentBlock(string $content, int $startIt): array
        {
            $endOfComment = Str::findFirst($content, '*}}', $startIt);

            if ($endOfComment === false) {
                $this->throwError($content, $startIt);
            }

            return [new NullBlock(), $endOfComment + 3];
        }

        private function parseExtendedCommentBlock(string $content, int $startIt): array
        {
            $it = $startIt;
            do {
                $closeTag = Str::findFirst($content, [
                    '{{+', '+}}',
                ], $it);

                switch (Str::substr($content, $closeTag, 3)) {
                    case '{{+':
                        [, $closeTag] = $this->parseExtendedCommentBlock($content, $closeTag + 3);
                        break;

                    case '+}}':
                        return [new NullBlock(), $closeTag + 3];
                }

                $it = $closeTag;
            } while (true);

            Assert::unreachable();
        }

        private function skipWhitespace(string $content, int $it): int
        {
            return Str::findFirstNotOf($content, " \t\r\n\v", $it);
        }

        private function skipWhitespaceToken(array $tokens, int $startIt): ?int
        {
            for ($it = $startIt; $it < Arr::len($tokens); ++$it) {
                if ($tokens[$it] instanceof WhitespaceToken) {
                    continue;
                }

                return $it;
            }

            return NULL;
        }

        private function interpretTokens(array $tokens, int $startIt): array
        {
            // let's make sense of this maddness
            $instructions = [];

            for ($it = 0; $it < Arr::len($tokens); ++$it) {
                $current = $tokens[$it];

                switch (get_class($current)) {
                    case KeywordToken::class:
                        $instructions[] = $current->getToken();
                        break;

                    case StringToken::class:
                    case LiteralToken::class:
                        $instructions[] = new Constant($current->getToken());
                        break;

                    case WhitespaceToken::class:
                        continue 2;

                    case SymbolToken::class:
                        switch ($current->getToken()) {
                            case '$':
                                [$inst, $it] = $this->interpretTokensVariable($tokens, $it);
                                $instructions[] = $inst;
                                break;

                            case '+':
                            case '-':
                            case '*':
                            case '/':
                            case '(':
                            case ')':
                                $instructions[] = $current->getToken();
                                break;

                            default:
                                Assert::unreachable('unknown symbol');
                        }
                        break;

                    default:
                        Assert::unreachable('unknown token');
                }
            }

            return [true, $instructions];
        }

        private function prepareInstructions(array $instructions): BlockInterface
        {
            if (Arr::len($instructions) === 1) {
                if ($instructions[0] instanceof Variable) {
                    return new PrintVariableBlock($instructions[0]);
                } else {
                    return new PrintConstantBlock($instructions[0]);
                }
            } else {
                [$ret,] = $this->prepareInstructionsTree($instructions);

                return new PrintExpressionBlock($ret);
            }
        }

        private function prepareInstructionsTree(array $instructions, int $startIt = 0, ?string $upTo = NULL): array
        {
            $elements = [];

            // let's order our elements
            for ($it = $startIt; $it < Arr::len($instructions); ++$it) {
                $current = $instructions[$it];

                if ($current === '(') {
                    [$el, $it] = $this->prepareInstructionsTree($instructions, $it + 1, ')');
                    $elements[] = $el;
                } else if ($current === ')' && $upTo === ')') {
                    break;
                } else {
                    $elements[] = $current;
                }
            }

            // now let's merge expression based on signs

            $jt = 0;
            $curr = [];

            while ($jt < Arr::len($elements)) {
                switch (Arr::len($curr)) {
                    case 0:
                        $curr[] = $elements[$jt];
                        break;

                    case 1:
                        switch ($elements[$jt]) {
                            case '+':
                            case '*':
                            case '/':
                            case '-':
                                $curr[] = $elements[$jt];
                                break;

                            default:
                                Assert::unreachable('unknown symbol');
                        }
                        break;

                    case 2:
                        $tmp = NULL;
                        if ($curr[0] instanceof Tree) {
                            if (Arr::contains(['*', '/'], $curr[1])) {
                                if (Arr::contains(['+', '-'], $curr[0]->getSign())) {
                                    $subTree = new Tree($curr[0]->getRight(), $curr[1], $elements[$jt]);
                                    $leftTree = new Tree($curr[0]->getLeft(), $curr[0]->getSign(), $subTree);
                                    $tmp = [$leftTree];
                                }
                            }
                        }
                        if ($tmp === NULL) {
                            $curr = [new Tree($curr[0], $curr[1], $elements[$jt])];
                        } else {
                            $curr = $tmp;
                        }
                        break;

                    default:
                        Assert::unreachable();
                }

                $jt++;
            }

            while (Arr::is($curr)) {
                $curr = Arr::first($curr);
            }

            return [new Group($curr), $it];
        }

        private function interpretTokensVariable(array $tokens, int $startIt): array
        {
            $it = $startIt + 1;

            $names = [];
            do {
                $nextIt = $this->skipWhitespaceToken($tokens, $it);
                if ($nextIt === NULL) {
                    break;
                }
                $it = $nextIt;
                $names[] = $tokens[$it]->getToken();
                $it++;

                $nextIt = $this->skipWhitespaceToken($tokens, $it);
                if ($nextIt === NULL) {
                    break;
                }
                $it = $nextIt;
            } while (Validate::typeRequirements($tokens[$it], SymbolToken::class, ['token' => '.']));

            return [new Variable($names, []), $it];
        }
    }
