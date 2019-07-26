<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Config;

    /**
     * Interface ConfigManagerInterface
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    interface ConfigManagerInterface
    {
        /**
         * Get value from configuration
         *
         * @param string $key Key separated by dots
         * @param mixed  $default
         *
         * @return mixed
         */
        public function get(string $key, $default = NULL);
    }
