<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine\SimpleTemplate;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Parser\Tokenizer\Tokenizer;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Template\Engine\TemplateEngineInterface;
    use PsychoB\Framework\Template\Generic\Block\EchoRawHtmlBlock;
    use PsychoB\Framework\Template\Generic\Block\NullBlock;
    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateBlockRepository;
    use PsychoB\Framework\Template\TemplateFilterRepository;
    use PsychoB\Framework\Template\TemplateState;
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
            $this->tokenizer->addGroup('symbols', ['$', '}}', '{{', '.', '|', ':', '?', '"', '=', '@'],
                SymbolToken::class, false);
            $this->tokenizer->addGroup('whitespace', [' ', "\t", "\r", "\n", "\v"], WhitespaceToken::class, true);
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

            $stream = $this->tokenizer->tokenize(Str::substr($content, $it));
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
    }
