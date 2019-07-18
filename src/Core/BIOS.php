<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Core;

    use PsychoB\Framework\Application\UnCacheAbleApp;
    use PsychoB\Framework\Core\Config\BootConfiguration;
    use PsychoB\Framework\Core\ErrorHandling\DumbErrorHandler;
    use PsychoB\Framework\Core\ErrorHandling\DumbExceptionHandler;
    use PsychoB\Framework\Core\Utility\Path;
    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\EnvSourceFactory;

    /**
     * Basic Input/Output System.
     *
     * This class should initialize basic environment for framework to work in.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class BIOS
    {
        /** @var DumbErrorHandler */
        protected $dumbErrorHandler = NULL;

        /** @var DumbExceptionHandler */
        protected $dumbExceptionHandler = NULL;

        /** @var DotEnv */
        protected $dotEnv = NULL;

        /** @var string */
        protected $basePath = "";

        /** @var string */
        protected $env = 'production';

        /** @var BootConfiguration */
        protected $bootConfiguration;

        /**
         * BIOS constructor.
         *
         * @param string $basePath
         */
        protected function __construct(string $basePath)
        {
            $this->basePath = $basePath;
        }

        /** @var BIOS */
        protected static $Instance = NULL;

        public static function new(...$args): BIOS
        {
            static::$Instance = new BIOS(...$args);
            return static::$Instance;
        }

        public static function getDotEnv(): DotEnv
        {
            return static::$Instance->dotEnv;
        }

        public function setUp(): void
        {
            // to framework to work properly, we need to have set up:
            $this->dumbExceptionHandler = new DumbExceptionHandler();
            $this->dumbExceptionHandler->register();

            // - error handler, that will rethrow all old PHP Errors as Exceptions
            $this->dumbErrorHandler = new DumbErrorHandler($this->dumbExceptionHandler);
            $this->dumbErrorHandler->register();

            // at this point we should have our DotEnv
            $this->dotEnv = new DotEnv($this->basePath,
                                       EnvSourceFactory::envVar(),                      // top priority _ENV
                                       EnvSourceFactory::getEnv(),                      // next all getenv
                                       EnvSourceFactory::dotEnv(),                      // next variables saved in .env
                                       EnvSourceFactory::dotEnvDotEnv('APP_ENV')   // last variables saved in .env.{APP_ENV}
            );

            if ($this->dotEnv->has('APP_ENV')) {
                $this->env = $this->dotEnv->get('APP_ENV', 'production');
            } else {
                $this->env = 'production';
                $this->dotEnv->set('APP_ENV', 'production');
            }

            $this->bootConfiguration = new BootConfiguration(Path::join($this->basePath, 'res', 'config', 'boot.php'));
        }

        public function makeApp(): UnCacheAbleApp
        {
            return new UnCacheAbleApp($this->basePath, $this->dotEnv);
        }

        public function tearDown(): void
        {
        }

        public function returnCode(): int
        {
            return 0;
        }

        public static function boot(string $basePath): int
        {
            $bios = BIOS::new($basePath);

            $bios->setUp();

            $app = $bios->makeApp();
            $app->run();

            $bios->tearDown();

            return $bios->returnCode();
        }
    }
