<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv;

    final class DotEnvSource
    {
        public static function envVar(bool $cache = true)
        {
            if ($cache) {
                return DotEnv::ORDER_ENV;
            } else {
                return [
                    'type'     => DotEnv::ORDER_ENV,
                    'volatile' => $cache,
                ];
            }
        }

        public static function dotEnv(bool $cache = true, string $file = '.env')
        {
            if ($cache && $file === '.env') {
                return DotEnv::ORDER_DOT_ENV;
            } else {
                return [
                    'type'     => DotEnv::ORDER_DOT_ENV,
                    'volatile' => $cache,
                    'file'     => $file,
                ];
            }
        }

        public static function dotEnvDotEnv(string $env, bool $cache = true, string $file = ',env')
        {
            return [
                'type'     => DotEnv::ORDER_DOT_ENV,
                'volatile' => $cache,
                'file'     => $file,
                'env'      => $env,
            ];
        }
    }
