<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel\Driver;

    use PsychoB\DependencyInjection\Container;
    use PsychoB\Framework\DotEnv\DotEnv;

    /**
     * Driver Interface.
     *
     * This interface is responsible for picking who should process this request.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    interface DriverInterface
    {
        /**
         * Return in what amount this driver could process current request. Negative numbers are discarded.
         *
         * @param DotEnv $env
         *
         * @return int
         */
        public static function supportsEnvironment(DotEnv $env): int;

        /**
         * Which class should be used to handle uncatched exceptions.
         *
         * @return string
         */
        public static function defaultExceptionHandler(): string;

        /**
         * Create application, that will be used to process this request
         *
         * @param Container $container
         *
         * @return ApplicationInterface
         */
        public static function createApplication(Container $container): ApplicationInterface;
    }
