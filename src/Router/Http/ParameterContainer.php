<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http;

    class ParameterContainer
    {
        protected $container = [];

        /**
         * ParameterContainer constructor.
         *
         * @param array $container
         */
        public function __construct(array $container)
        {
            $this->container = $container;
        }

        public function has(string $key): bool
        {
            return array_key_exists($key, $this->container);
        }
    }
