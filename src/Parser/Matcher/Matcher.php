<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Matcher;

    class Matcher
    {
        public const MATCH_START       = '__start';
        public const FLAG_IS_STRING    = 0b100000000000000000000000000000000000000000000000000000000000000;
        public const FLAG_AS_ARRAY     = 0b010000000000000000000000000000000000000000000000000000000000000;
        public const FLAG_COUNT        = 0b000000000000000000000000000000000000000000000000000000000000001;
        public const FLAG_TREE_START   = 0b000000000000000000000000000000000000000000000000000000000000010;
        public const FLAG_MAKE_NOTE    = 0b000000000000000000000000000000000000000000000000000000000000100;
        public const FLAG_ONE_OF_THE   = 0b000000000000000000000000000000000000000000000000000000000001000;
        public const FLAG_USE_MULTIPLE = 0b000000000000000000000000000000000000000000000000000000000010000;
        public const FLAG_TREE_STOP    = 0b000000000000000000000000000000000000000000000000000000000100000;
        public const FLAG_NODE         = 0b000000000000000000000000000000000000000000000000000000001000000;

        protected $matches = [];

        public function addMatch(string $name, $definition, int $flags = 0): self
        {
            $this->matches[$name] = [
                'def' => $definition,
                'flags' => $flags,
            ];

            return $this;
        }

        public function buildParser()
        {
            return (new ParserBuilder($this->matches))->build();
        }
    }
