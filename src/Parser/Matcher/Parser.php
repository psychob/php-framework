<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Matcher;

    class Parser
    {
        protected $matched = [];

        /**
         * Parser constructor.
         *
         * @param array $matched
         */
        public function __construct(array $matched)
        {
            $this->matched = $matched;
        }
    }
