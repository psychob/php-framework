<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel;

    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\EnvSourceFactory;
    use PsychoB\Framework\Kernel\Environment;
    use PsychoB\Framework\Kernel\ErrorHandling\ErrorHandler;

    /**
     * Application Kernel.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    final class Kernel
    {
        /**
         * Initializes basic environment for framework
         *
         * @param string $masterBootRecord Path of base application
         *
         * @return Environment
         */
        public static function boot(string $masterBootRecord): Environment
        {
            //
            // Framework loads .env variables in following order:
            //  1. we load variables from environment
            //  2. we load variables from .env file in base application directory
            //  3. we load variables from .env.{APP_ENV}
            //
            $dotEnv = new DotEnv($masterBootRecord,
                                 EnvSourceFactory::getEnv(),
                                 EnvSourceFactory::dotEnv(),
                                 EnvSourceFactory::dotEnvDotEnv('APP_ENV')
            );

            $errorHandler = new ErrorHandler();
            $errorHandler->register();

            return new Environment($masterBootRecord, $dotEnv, $dotEnv->get('APP_ENV', 'production'), $errorHandler);
        }
    }
