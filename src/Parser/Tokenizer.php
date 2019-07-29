<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser;

    use PsychoB\Framework\DependencyInjection\Resolver\Tag\ResolverNeverCache;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokens\TokenInterface;
    use PsychoB\Framework\Parser\Tokens\WhitespaceToken;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Assert;
    use PsychoB\Framework\Utility\Str;

    class Tokenizer implements ResolverNeverCache
    {
        /** @var string[][] */
        protected $groups = [
            'literal' => [
                'symbols' => NULL,
                'class' => LiteralToken::class,
                'combinations' => true,
            ],
            'whitespace' => [
                'symbols' => [' ', "\n", "\r", "\t", "\v"],
                'class' => WhitespaceToken::class,
                'combinations' => true,
            ],
        ];

        public function addGroup(string $group, array $symbols, string $class, bool $allowCombining): void
        {
            $this->groups[$group] = [
                'symbols' => $symbols,
                'class' => $class,
                'combinations' => $allowCombining,
            ];
        }

        public function tokenizeFile(string $path)
        {
            return $this->tokenize(file_get_contents($path));
        }

        public function tokenize(string $content)
        {
            $current = '';
            $currentType = 'literal';
            $startIt = 0;

            for ($it = 0; $it < strlen($content); ++$it) {
                $chr = $content[$it];
                $possibleValues = $this->getPossibleGroupsFor($chr);

                if (count($possibleValues) === 1) {
                    // default case
                    [$type, $canStartSequence, $canCombine, $symbols, $isWholeSymbol] = $possibleValues[0];

                    if ($canStartSequence) {
//                        Assert::isFalse($isWholeSymbol, LogicParserException::class,
//                            'Symbol must be whole, if it can not be continue');

                        // Here we need to peek in future, and depending on if we could find one of the symbols
                        // we either fall back to literal, or swallow whole symbol

                        $found = false;

                        foreach (Arr::sortValues($symbols, Str::COMPARE_LENGTH_REVERSE) as $symbol) {
                            $len = Str::length($symbol);

                            if (Str::equalsPart($content, $it, $len, $symbol, 0, $len)) {
                                $found = $symbol;
                                break;
                            }
                        }

                        if ($found !== false) {
                            if ($currentType !== $type) {
                                if ($current !== '') {
                                    yield $this->newToken($currentType, $current, $startIt, $it);
                                }

                                $current = $found;
                                $currentType = $type;
                                $startIt = $it;
                                $it += Str::length($found) - 1;
                            } else {
                                if ($canCombine) {
                                    $current .= $found;
                                    $it += Str::length($found) - 1;
                                } else {
                                    yield $this->newToken($currentType, $current, $startIt, $it);
                                    $current = $found;
                                    $currentType = $type;
                                    $startIt = $it;
                                    $it += Str::length($found) - 1;
                                }
                            }
                        } else {
                            if ($isWholeSymbol) {
                                // in this case, our initial $chr is symbol
                                if ($currentType !== $type) {
                                    // if we are different, then we need to commit current buffer (if it exists)
                                    if ($current !== '') {
                                        yield $this->newToken($currentType, $current, $startIt, $it);
                                    }

                                    $current = $chr;
                                    $currentType = $type;
                                    $startIt = $it;
                                } else {
                                    if ($canCombine) {
                                        $current .= $chr;
                                    } else {
                                        yield $this->newToken($currentType, $current, $startIt, $it);
                                        $current = '';
                                        $startIt = $it;
                                    }
                                }
                            } else {
                                // if not, then we dump it into literal token
                                if ($currentType !== 'literal') {
                                    if ($current !== '') {
                                        yield $this->newToken($currentType, $current, $startIt, $it);
                                    }

                                    $current = $chr;
                                    $currentType = 'literal';
                                    $startIt = $it;
                                } else {
                                    $current .= $chr;
                                }
                            }
                        }
                    } else {
                        Assert::isTrue($isWholeSymbol, LogicParserException::class,
                            'Symbol must be whole, if it can not be continue');

                        if ($currentType !== $type) {
                            // if we are different, then we need to commit current buffer (if it exists)
                            if ($current !== '') {
                                yield $this->newToken($currentType, $current, $startIt, $it);
                            }

                            $current = $chr;
                            $currentType = $type;
                            $startIt = $it;
                        } else {
                            if ($canCombine) {
                                $current .= $chr;
                            } else {
                                yield $this->newToken($currentType, $current, $startIt, $it);
                                $current = '';
                                $startIt = $it;
                            }
                        }
                    }
                }
            }

            if (!empty($current)) {
                yield $this->newToken($currentType, $current, $startIt, $it);
            }
        }

        private function getPossibleGroupsFor(string $chr): array
        {
            // we need to check if this character can start any of the sequences, or
            // this character belongs to any group. If it doesn't then we assume that it's literal

            $canStartSequence = [];
            $isSymbol = [];

            foreach ($this->groups as $name => $group) {
                foreach ($group['symbols'] ?? [] as $symbol) {
                    if (Str::equals($symbol, $chr, strlen($chr))) {
                        if ($symbol === $chr) {
                            $isSymbol[$name] = true;
                        } else {
                            $canStartSequence[$name][] = $symbol;
                        }
                    }
                }
            }

            if (empty($canStartSequence) && empty($isSymbol)) {
                return [[
                    'literal',
                    false,
                    true,
                    [],
                    true,
                ]];
            }

            $ret = [];

            foreach ($canStartSequence as $name => $symbol) {
                $ret[$name] = [
                    $name, // name of group
                    true, // canStartSequence
                    $this->groups[$name]['combinations'], // canCombine
                    $symbol, // possible symbols
                    false, // isSymbol
                ];
            }

            foreach ($isSymbol as $name => $is) {
                if (Arr::has($ret, $name)) {
                    $ret[$name][4] = true;
                } else {
                    $ret[$name] = [
                        $name, // name of group
                        false, // canStartSequence
                        $this->groups[$name]['combinations'], // canCombine
                        [$chr], // possible symbol
                        true, // isSymbol
                    ];
                }
            }

            return Arr::dropKeys($ret);
        }

        private function newToken(string $type, string $str, int $sIt, int $it): TokenInterface
        {
            $group = $this->groups[$type];

            return new $group['class']($str, $sIt, $it);
        }
    }
