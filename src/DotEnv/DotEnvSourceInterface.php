<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv;

    use PsychoB\Framework\Exceptions\EntryNotFoundException;

    /**
     * Interface for dotEnv sources
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    interface DotEnvSourceInterface
    {
        /**
         * Check if variables from this source can be cached
         *
         * @return bool
         */
        public function isVolatile(): bool;

        /**
         * Get value from environment
         *
         * @param string $value
         *
         * @return mixed
         *
         * @throws EntryNotFoundException
         */
        public function get(string $value);

        /**
         * Check if value exist in environment
         *
         * @param string $value
         *
         * @return bool
         */
        public function has(string $value): bool;
    }
