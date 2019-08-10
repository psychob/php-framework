<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Config;

    use PsychoB\Framework\Utility\Arr;

    class ArrayConfigManager implements ConfigManagerInterface
    {
        /** @var mixed[] */
        protected $container;

        /**
         * Get value from configuration
         *
         * @param string $key Key separated by dots
         * @param mixed  $default
         *
         * @return mixed
         */
        public function get(string $key, $default = NULL)
        {
            return Arr::recursiveGet($this->container, Arr::explode($key, '.'), $default);
        }
    }
