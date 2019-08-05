<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Matcher;

    use PsychoB\Framework\Parser\Matcher\Matches\MatchString;
    use PsychoB\Framework\Utility\Arr;

    class ParserBuilder
    {
        /**
         * @var array
         */
        private $matches;

        /**
         * ParserBuilder constructor.
         *
         * @param array $matches
         */
        public function __construct(array $matches)
        {
            $this->matches = $matches;
        }

        public function build(): Parser
        {
            $knownMatches = [];
            $compiledMatches = [];

            foreach ($this->matches as $name => $match) {
                if ($match['flags'] === Matcher::FLAG_IS_STRING) {
                    $matcher = new MatchString();
                    $knownMatches[$name] = $matcher;
                    $compiledMatches[$name] = $matcher;
                } else {
                    if (Arr::is($match['def'])) {
                        // multiple matches
                    } else {
                        dump(explode(' ', $match['def']));
                    }
                }
            }

            return new Parser($compiledMatches);
        }
    }
