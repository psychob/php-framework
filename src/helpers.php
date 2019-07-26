<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    use PsychoB\Framework\Application\AppInterface;

    function env(string $key, $default = NULL)
    {
        return getenv($key) ?? $default;
    }

    function config(string $key, $default = NULL)
    {
        return resolve(ConfigManager::class)->get($key, $default);
    }

    function app(): AppInterface
    {
    }

    function resolve(string $class, array $arguments = [])
    {
        return app()->resolver($class, $arguments);
    }
