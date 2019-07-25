<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework;

    use PsychoB\Framework\Application\App;
    use PsychoB\Framework\Application\AppInterface;
    use PsychoB\Framework\ErrorHandling\DumbExceptionHandler;
    use PsychoB\Framework\ErrorHandling\ErrorTrampoline;
    use PsychoB\Framework\Utility\SingletonTrait;

    /**
     * Base class which initializes framework.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Kernel
    {
        use SingletonTrait;

        public static function boot(...$args): void
        {
            $kernel = static::make(...$args);
            $kernel->init();
            $app = $kernel->createApp();
            $app->run();
            $kernel->deinit();
        }

        /** @var string */
        protected $basePath;

        /** @var null|callable */
        protected $oldErrorHandler;

        /** @var null|callable */
        protected $oldExceptionHandler;

        public function __construct(string $appBasePath)
        {
            $this->basePath = $appBasePath;
        }

        /**
         * This method initializes framework mainframe
         */
        public function init(): void
        {
            // we want to have better support for Errors, so we want to throw them and not display them
            $this->oldErrorHandler = set_error_handler([ErrorTrampoline::class, 'eject']);

            // also we want to have some control over how exceptions are displayed in early stage of framework
            // initialization
            $this->oldExceptionHandler = set_exception_handler([DumbExceptionHandler::class, 'catch']);

            // we also want to tie ourself to shutdown function, so we could hijack errors
            register_shutdown_function([ErrorTrampoline::class, 'shutdown']);
        }

        /**
         * This method creates application that will service current request. This method must be called after call
         * to init.
         *
         * @return AppInterface
         */
        public function createApp(): AppInterface
        {
            /// TODO: In final application, here we would decided what kind of application we want to bring up, for
            /// TODO: example application that is cached, or application that has cache disabled, or something like
            /// TODO: that. But because this is first version we will always create basic application

            return new App($this->basePath);
        }

        /**
         * This method clears framework context
         */
        public function deinit(): void
        {
            restore_exception_handler();
            restore_error_handler();
        }
    }
