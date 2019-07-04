<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv;

    /**
     * Class used for creating source definitions for DotEnv class.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    final class EnvSourceFactory
    {
        /**
         * Create source that fetches variables from getenv.
         *
         * @param bool $cache Allow caching results.
         *
         * @return int|array
         */
        public static function getEnv(bool $cache = true)
        {
            if ($cache) {
                return DotEnv::ORDER_GETENV;
            } else {
                return [
                    'type'     => DotEnv::ORDER_GETENV,
                    'volatile' => !$cache,
                ];
            }
        }

        /**
         * Creates source that fetches variables from .env file
         *
         * @param bool   $cache Allow caching results
         * @param string $file  File to fetch variables from
         *
         * @return array|int
         */
        public static function dotEnv(bool $cache = true, string $file = '.env')
        {
            if ($cache && $file === '.env') {
                return DotEnv::ORDER_DOT_ENV;
            } else {
                return [
                    'type'     => DotEnv::ORDER_DOT_ENV,
                    'volatile' => !$cache,
                    'file'     => $file,
                ];
            }
        }

        /**
         * Creates source that fetches variables from .env.{variable}
         *
         * @param string $env   Variable that holds {variable}
         * @param bool   $cache Allow caching results
         * @param string $file  File to fetch variables
         *
         * @return array
         */
        public static function dotEnvDotEnv(string $env, bool $cache = true, string $file = '.env'): array
        {
            return [
                'type'     => DotEnv::ORDER_DOT_ENV_ENVIRONMENT,
                'volatile' => !$cache,
                'file'     => $file,
                'env'      => $env,
            ];
        }

        /**
         * Creates source that fetches variable from $_ENV
         *
         * @param bool $cache Allow caching results
         *
         * @return array|int
         */
        public static function envVar(bool $cache = true)
        {
            if ($cache) {
                return DotEnv::ORDER_ENV_VAR;
            } else {
                return [
                    'type'     => DotEnv::ORDER_ENV_VAR,
                    'volatile' => !$cache,
                ];
            }
        }

        public static function custom(DotEnvSourceInterface $custom): array
        {
            return [
                'type' => DotEnv::ORDER_CUSTOM,
                'bind' => $custom,
            ];
        }
    }
