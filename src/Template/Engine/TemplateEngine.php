<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Template\Generic\Block\AppConfigBlock;
    use PsychoB\Framework\Template\Generic\Block\EmptyBlock;
    use PsychoB\Framework\Template\Generic\Block\RawHtmlBlock;
    use PsychoB\Framework\Template\Generic\Block\VariableBlock;
    use PsychoB\Framework\Utility\Str;

    class TemplateEngine implements TemplateEngineInterface
    {
        use TemplateEngineExecutorTrait;

        private const SYMBOLS    = '.:"\'{}|';
        private const WHITESPACE = " \t\r\n\v";

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

        private function skipWhitespacesFrom(string $content, int $startIt): int
        {
            $ret = Str::findFirstNotOf($content, self::WHITESPACE, $startIt);
            if ($ret === false) {
                /// TODO: Throw exception because there is no more non-whitespace characters
            }

            return $ret;
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

        private function fetchExpression(string $content, int $startIt): array
        {
            $it = $this->skipWhitespacesFrom($content, $startIt);

            switch ($content[$it]) {
                case '$':
                    return $this->fetchVariableBlock($content, $it);

                case '@':
                    return $this->fetchApplicationBlock($content, $it);

                default:
                    return $this->fetchBlock($content, $it);
            }
        }

        private function fetchVariableBlock(string $content, int $it): array
        {
            // variable syntax is:
            // $name [. accessor]+ [|filter[: arg]+]+
            // it can also use alternative syntax:
            // $name ['accessor']
            // $name [$accessor]

            [$variable, $it] = $this->fetchFullVariable($content, $it);

            return [new VariableBlock($variable), $it + 2];
        }

        private function fetchFullVariable(string $content, int $it): array
        {
            $variable = [
                'name' => '',
                'accessors' => [],
                'filters' => [],
            ];

            [$variable['name'], $it] = $this->fetchSimpleToken($content, $it + 1);

            $it = $this->skipWhitespacesFrom($content, $it);
            while ($content[$it] === '.') {
                [$acc, $it] = $this->fetchSimpleToken($content, $it + 1);

                $variable['accessors'][] = $acc;
            }

            $it = $this->skipWhitespacesFrom($content, $it);
            while ($content[$it] === '|') {
                [$name, $it] = $this->fetchSimpleToken($content, $it + 1);
                $it = $this->skipWhitespacesFrom($content, $it);

                $args = [];
                while ($content[$it] === ':') {
                    [$arg, $it] = $this->fetchSimpleToken($content, $it + 1);
                    $it = $this->skipWhitespacesFrom($content, $it);

                    $args[] = $arg;
                }

                $variable['filters'][] = [
                    'name' => $name,
                    'args' => $args,
                ];
            }
            $it = $this->skipWhitespacesFrom($content, $it);

            return [$variable, $it];
        }

        private function fetchSimpleToken(string $content, int $startIt): array
        {
            $it = $this->skipWhitespacesFrom($content, $startIt);
            $last = Str::findFirstOf($content, self::SYMBOLS . self::WHITESPACE, $it);

            return [Str::substr($content, $it, $last - $it), $last];
        }

        private function fetchApplicationBlock(string $content, int $startIt): array
        {
            [$variable, $it] = $this->fetchFullVariable($content, $startIt);

            switch ($variable['name']) {
                case 'config':
                    return [new AppConfigBlock($variable['accessors'], $variable['filters']), $it];
            }
        }

        protected function fetchBlock(string $content, int $startIt): array
        {
        }
    }
