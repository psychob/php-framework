<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel\Driver;

    use PsychoB\DependencyInjection\Container;

    interface DriverInterface
    {
        public static function supportsEnvironment(): int;

        public static function defaultErrorHandler(): string;

        public static function createApplication(Container $container): ApplicationInterface;
    }
