<?php
    //
    // psychob/ja
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel;

    use PsychoB\DependencyInjection\Container;
    use PsychoB\Framework\Application\Console\ConsoleExceptionHandler;
    use Throwable;

    /**
     * Exception Handler.
     *
     * This class handles exception that are not intercepted by any catch (...) on the way. This class will only be used
     * at point after Kernel initializes it, and before Environment sets up Application Driver.
     *
     * Drivers should register their own ExceptionHandlerInterface after they are initialized.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class ExceptionHandler implements ExceptionHandlerInterface
    {
        /** @var Container */
        protected $container;

        /**
         * ExceptionHandler constructor.
         *
         * @param Container $container
         */
        public function __construct(Container $container)
        {
            $this->container = $container;
        }

        /**
         * Registers this exception handler as current
         */
        public function register()
        {
            set_exception_handler([$this, 'catchException']);
        }

        /** @inheritDoc */
        public function catchException(Throwable $t)
        {
            if (php_sapi_name() !== 'cli') {
                http_response_code(500);
                header('Content-Type: text/plain');
            }

            $this->container->make(ConsoleExceptionHandler::class)->catchException($t);
        }
    }
