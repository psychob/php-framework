<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    use PsychoB\Framework\Router\Middleware\ExecuteControllerMiddleware;
    use PsychoB\Framework\Router\Middleware\HandleExceptionMiddleware;
    use PsychoB\Framework\Router\Middleware\OptionsMiddleware;
    use PsychoB\Framework\Router\Middleware\TrustedProxyMiddleware;

    return [
        'basePath' => '/',

        'middlewares' => [
            'default' => [
                HandleExceptionMiddleware::class,
                OptionsMiddleware::class,
                TrustedProxyMiddleware::class,
                ExecuteControllerMiddleware::class,
            ],

            'aliases' => [
                'DebugMode' => DebugModeMiddleware::class,
                'DisableCache' => DisableCacheMiddleware::class,
            ],
        ],

        'param_types' => [
            'str' => StringValidator::class,
        ]
    ];
