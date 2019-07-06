<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;

    /**
     * Interface for Container
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    interface ContainerInterface
    {
        /**
         * Old value is overrided
         */
        public const TYPE_OVERRIDE = 0;

        /**
         * If there is previous value, exception is thrown
         */
        public const TYPE_EXCEPTION_ON_OVERRIDE = 1;

        /**
         * Check if $key exist in container. This method should never throw exception.
         *
         * @param string $key
         *
         * @return bool
         */
        public function has(string $key): bool;

        /**
         * Retrieve $key value
         *
         * @param string $key
         *
         * @return mixed
         */
        public function get(string $key);

        /**
         * Add new $value for $key
         *
         * @param string $key
         * @param mixed  $value
         * @param int    $type ContainerInterface::TYPE_OVERRIDE or ContainerInterface::TYPE_EXCEPTION_ON_OVERRIDE
         */
        public function add(string $key, $value, int $type = self::TYPE_OVERRIDE): void;

        /**
         * Retrieve psr compatible adapter
         *
         * @return PsrContainerInterface
         */
        public function psr(): PsrContainerInterface;
    }
