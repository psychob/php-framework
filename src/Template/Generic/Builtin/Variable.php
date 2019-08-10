<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Builtin;

    class Variable
    {
        /** @var string[] */
        protected $access;

        /**
         * Variable constructor.
         *
         * @param string[] $access
         */
        public function __construct(array $access)
        {
            $this->access = $access;
        }

        public function getAccessors()
        {
            return $this->access;
        }
    }
