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

        /** @var mixed[] */
        protected $filters;

        /**
         * Variable constructor.
         *
         * @param string[] $access
         * @param array    $filters
         */
        public function __construct(array $access, array $filters)
        {
            $this->access = $access;
            $this->filters = $filters;
        }

        public function getAccessors(): array
        {
            return $this->access;
        }

        public function getFilters(): array
        {
            return $this->filters;
        }
    }
