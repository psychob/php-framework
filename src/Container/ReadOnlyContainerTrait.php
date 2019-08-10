<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Container;

    use PsychoB\Framework\Utility\Arr;

    trait ReadOnlyContainerTrait
    {
        protected $container;

        public function has($key): bool
        {
            return Arr::has($this->container, $key);
        }

        public function get($key)
        {
            return $this->container[$key];
        }
    }
