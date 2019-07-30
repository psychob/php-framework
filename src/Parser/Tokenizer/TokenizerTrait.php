<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Exception\BaseException;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokens\TokenInterface;
    use PsychoB\Framework\Parser\Tokens\WhitespaceToken;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    trait TokenizerTrait
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

        protected function tokenizeImpl(string $content)
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
                            // if we have symbol, then we can assume current type is correct. But if we don't then we
                            // need to append it to literal token
                            if (!$isWholeSymbol) {
                                $type = 'literal';
                                $canCombine = true;
                            }

                            $tok = $this->pushToken($currentType, $current, $type, $canCombine, $chr, $startIt, $it);
                            if ($tok !== NULL) {
                                yield $tok;
                            }
                        }
                    } else {
                        Assert::isTrue($isWholeSymbol, 'Symbol must be whole, if it can not be continue');

                        $tok = $this->pushToken($currentType, $current, $type, $canCombine, $chr, $startIt, $it);
                        if ($tok !== NULL) {
                            yield $tok;
                        }
                    }
                } else {
                    throw new BaseException("Todo");
                }
            }

            if (!empty($current)) {
                yield $this->newToken($currentType, $current, $startIt, $it);
            }
        }

        protected function getPossibleGroupsFor(string $chr): array
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
                return [$this->newSuggestion('literal', false, true, [], true)];
            }

            $ret = [];

            foreach ($canStartSequence as $name => $symbol) {
                $ret[$name] = $this->newSuggestion($name, true, $this->groups[$name]['combinations'], $symbol, false);
            }

            foreach ($isSymbol as $name => $is) {
                if (Arr::has($ret, $name)) {
                    $ret[$name][4] = true;
                } else {
                    $ret[$name] = $this->newSuggestion($name, false, $this->groups[$name]['combinations'], [$chr],
                        true);
                }
            }

            return Arr::dropKeys($ret);
        }

        protected function newToken(string $type, string $str, int $sIt, int $it): TokenInterface
        {
            return new $this->groups[$type]['class']($str, $sIt, $it);
        }

        protected function newSuggestion(string $name,
            bool $canStartSequence,
            bool $canCombine,
            array $symbols,
            bool $isSymbol): array
        {
            return [$name, $canStartSequence, $canCombine, $symbols, $isSymbol,];
        }

        protected function pushToken(string &$currentType,
            string &$current,
            string $type,
            bool $canCombine,
            string $chr,
            int &$startIt,
            int $it): ?TokenInterface
        {
            $token = NULL;

            if ($currentType !== $type) {
                // if we are different, then we need to commit current buffer (if it exists)
                if ($current !== '') {
                    $token = $this->newToken($currentType, $current, $startIt, $it);
                }

                $current = $chr;
                $currentType = $type;
                $startIt = $it;
            } else {
                if ($canCombine) {
                    $current .= $chr;
                } else {
                    $token = $this->newToken($currentType, $current, $startIt, $it);
                    $current = $chr;
                    $startIt = $it;
                }
            }

            return $token;
        }
    }
