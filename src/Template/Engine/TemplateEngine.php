<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Engine;

    use MongoDB\Driver\Monitoring\Subscriber;
    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Template\Block\EchoRawHtmlBlock;
    use PsychoB\Framework\Template\Block\PrintVariableBlock;
    use PsychoB\Framework\Utility\Str;

    class TemplateEngine implements TemplateEngineInterface
    {
        use TemplateEngineExecutorTrait;

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
            $it = $this->skipWhitespacesFrom($content, $startIt);

            switch ($content[$it]) {
                case '@':
                    return $this->fetchAppInstruction($content, $it);

                case '$':
                    return $this->fetchVarInstruction($content, $it);

                case '*':
                    return $this->fetchSimpleCommentInstruction($content, $it);

                case '+':
                    return $this->fetchExtendedCommentInstruction($content, $it);

                default:
                    return $this->fetchCustomInstruction($content, $it);
            }
        }

        private function skipWhitespacesFrom(string $content, int $startIt): int
        {
            $ret = Str::findFirstNotOf($content, " \t\r\n\v", $startIt);
            if ($ret === false) {
                /// TODO: Throw exception because there is no more non-whitespace characters
            }

            return $ret;
        }

        private function fetchVarInstruction(string $content, int $startIt)
        {
            // var can have following format:
            // $name[.sub]+ [| filter[:arg]+]+

            $variable = '';
            $accessors = [];
            $filters = [];
            $it = $startIt + 1;

            $nextIt = Str::findFirstOf($content, '.|}', $it);
            $variable = Str::trim(Str::substr($content, $it, $nextIt - $it));

            $it = $nextIt;

            if ($content[$it] === '.') {
                do {
                    $dotStart = $it + 1;
                    $it = Str::findFirstOf($content, '.|}', $dotStart);
                    $acc = Str::substr($content, $dotStart, $it - $dotStart);
                    $accessors[] = Str::trim($acc);
                } while ($content[$it] === '.');

                $nextIt = $it;
            }

            if ($content[$it] === '|') {
                do {
                    $fncStart = $it + 1;
                    $it = Str::findFirstOf($content, '|:}', $fncStart);
                    $fnc = Str::substr($content, $fncStart, $it - $fncStart);
                    $fnc = Str::trim($fnc);
                    $arguments = [];

                    if ($content[$it] === ':') {
                        do {
                            $argStart = $it + 1;
                            $it = Str::findFirstOf($content, '.|}', $argStart);
                            $arg = Str::substr($content, $argStart, $it - $argStart);
                            $arguments[] = Str::trim($arg);
                        } while ($content[$it] === '.');
                    }

                    $filters[] = ['name' => $fnc, 'arguments' => $arguments];
                    $nextIt = $it;
                } while ($content[$it] === '|');
            }

            if ($content[$nextIt] === '}') {
                if ($content[$nextIt + 1] === '}') {
                    return [new PrintVariableBlock($variable, $accessors, $filters), $it + 2];
                } else {
                    $this->throwSyntaxError('{ is not followed by {', $it);
                }
            }

            Assert::unreachable('Unknown format');
        }
    }
