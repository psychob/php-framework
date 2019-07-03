<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel;

    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\DotEnvSource;

    class Kernel
    {
        public static function boot($func, string $basePath): int
        {
            $dotEnv = new DotEnv($basePath, DotEnvSource::envVar(), DotEnvSource::dotEnv(),
                                 DotEnvSource::dotEnvDotEnv('APP_ENV'));

            if (!$dotEnv->has('APP_ENV')) {
                $dotEnv->set('APP_ENV', 'production');
            }

            return static::catchException(function () use($dotEnv, $func, $basePath) {
                static::bootInto($basePath, $dotEnv, $func);
            });
        }
    }
