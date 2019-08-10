<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer;

    use Generator;
    use PsychoB\Framework\Container\AbstractCacheableGenerator;
    use PsychoB\Framework\Parser\Tokenizer\Exception\UnexpectedCharacterException;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\TokenInterface;
    use PsychoB\Framework\Parser\Tokenizer\Transformers\TransformerInterface;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    abstract class AbstractTokenStream extends AbstractCacheableGenerator
    {
        /** @var mixed[] */
        protected $groups = [];
        /** @var TransformerInterface[] */
        protected $transformers = [];
        /** @var string */
        private $tokenCache = '';
        /** @var string */
        private $tokenType = '';
        /** @var int */
        private $tokenStart = 0;
        /** @var string */
        private $tokenClass = '';
        /** @var string */
        private $tokenCombine = '';

        protected abstract function loadMoreContent(): ?string;

        protected function getGenerator(): Generator
        {
            $tokens =  $this->parseContent();

            foreach ($this->transformers as $transformer) {
                $tokens = $transformer->transform($tokens);
            }

            return $tokens;
        }

        private function parseContent(): Generator
        {
            $offsetIt = 0;
            while ($content = $this->loadMoreContent()) {
                foreach ($this->parseChunk($content, $offsetIt) as $token) {
                    yield $token;
                }
            }

            if ($this->tokenCache !== '') {
                yield $this->finishChunks();
            }
        }

        private function parseChunk(string $content, int &$offsetIt): Generator
        {
            if ($this->hasOnlyOneUnlimitedGroup()) {
                $this->tokenCache .= $content;
                $this->tokenType = Arr::first($this->groups)['name'];

                if ($this->tokenStart !== -1) {
                    $this->tokenStart = $offsetIt;
                }

                $offsetIt += strlen($content);

                return;
            }

            for ($it = 0; $it < strlen($content);) {
                $element = $content[$it];
                $currentIt = $it;
                $groups = $this->getPotentialGroupsFor($element);

                if (empty($groups)) {
                    // there is no valid character
                    throw new UnexpectedCharacterException();
                }

                $priorityList = $this->buildPriorityFromGroups($groups);
                [$str, $it, $name] = $this->getCharacterFromPriority($groups, $priorityList, $content, $it);

                [$name, $allowedSymbols, $class, $combine] = Arr::first(Arr::filter($groups,
                    function ($e) use ($name): bool {
                        return $e[0] === $name;
                    }));

                if ($this->tokenCache !== '' && $this->tokenType !== '') {
                    if ($this->tokenType !== $name || $this->tokenCombine === false) {
                        yield $this->newToken($this->tokenCache, $this->tokenType, $this->tokenStart);
                        $this->tokenCache = '';
                        $this->tokenStart = $offsetIt + $currentIt;
                    }
                }

                $this->tokenCache .= $str;
                $this->tokenType = $name;
                $this->tokenClass = $class;
                $this->tokenCombine = $combine;
            }

            $offsetIt += strlen($content);
        }

        private function hasOnlyOneUnlimitedGroup(): bool
        {
            if (Arr::len($this->groups) === 1) {
                return Arr::len(Arr::first($this->groups)['symbols']) === 0;
            }

            return false;
        }

        private function finishChunks(): TokenInterface
        {
            return $this->newToken($this->tokenCache, $this->tokenType, $this->tokenStart);
        }

        private function newToken(string $content, string $type, int $start, int $length = -1): TokenInterface
        {
            if ($length === -1) {
                $length = Str::len($content);
            }

            foreach ($this->groups as $name => $group) {
                if ($name === $type) {
                    return new $group['class']($content, $start, $start + $length);;
                }
            }
        }

        private function getPotentialGroupsFor(string $str): array
        {
            $candidates = [];

            foreach ($this->groups as $name => $group) {
                $possibility = [];

                foreach ($group['symbols'] as $symbol) {
                    if (Str::len($symbol) >= Str::len($str)) {
                        if (Str::substr($symbol, 0, Str::len($str)) === $str) {
                            $possibility[] = $symbol;
                        }
                    }
                }

                if (!empty($possibility)) {
                    $candidates[] = [
                        $name,
                        $possibility,
                        $group['class'],
                        $group['allow_combining'],
                    ];
                }
            }

            foreach ($this->groups as $name => $group) {
                if (Arr::len($group['symbols']) === 0) {
                    $candidates[] = [
                        $name,
                        [],
                        $group['class'],
                        $group['allow_combining'],
                    ];
                    break;
                }
            }

            return $candidates;
        }

        private function buildPriorityFromGroups(array $groups): array
        {
            // in this case we need to put all possible symbols in array, from longest to shortest
            // first let's assemble it
            $listOfSymbols = [];

            foreach ($groups as $group) {
                foreach ($group[1] as $symbol) {
                    $listOfSymbols[] = ['name' => $group[0], 'symbol' => $symbol];
                }

                if (empty($group[1])) {
                    $listOfSymbols[] = ['name' => $group[0], 'symbol' => []];
                }
            }

            return Arr::sortByCustom($listOfSymbols, function ($el) {
                return Arr::len($el);
            }, true);
        }

        private function getCharacterFromPriority(array $allowedGroups,
            array $allowedSymbols,
            string $content,
            int $strIt): array
        {
            foreach ($allowedSymbols as $groupSymbol) {
                $name = $groupSymbol['name'];
                $symbol = $groupSymbol['symbol'];

                if (Arr::is($symbol)) {
                    return [$content[$strIt], $strIt + 1, $name];
                }

                if (Str::equals($content, $symbol, Str::len($symbol), $strIt)) {
                    return [$symbol, $strIt + Str::len($symbol), $name];
                }
            }
        }
    }
