<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel;

    use PsychoB\DependencyInjection\Container;
    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\Kernel\Driver\ApplicationInterface;
    use PsychoB\Framework\Kernel\Driver\DriverInterface;
    use PsychoB\Framework\Kernel\ErrorHandling\ErrorHandler;
    use PsychoB\Framework\Kernel\ErrorHandling\ExceptionHandler;
    use PsychoB\Framework\Kernel\ErrorHandling\ExceptionHandlerInterface;
    use PsychoB\Framework\Kernel\Exception\AmbiguousDriverSelectionException;
    use PsychoB\Framework\Kernel\Exception\NoDriverSelectedException;
    use PsychoB\Framework\Kernel\Exception\NoSuitableDriverSelectedException;

    class Environment
    {
        /** @var string */
        protected $basePath;

        /** @var DotEnv */
        protected $dotEnv;

        /** @var string */
        protected $environment;

        /** @var ErrorHandler */
        protected $errorHandler;

        /**
         * Environment constructor.
         *
         * @param string       $basePath
         * @param DotEnv       $dotEnv
         * @param string       $environment
         * @param ErrorHandler $errorHandler
         */
        public function __construct(string $basePath,
                                    DotEnv $dotEnv,
                                    string $environment,
                                    ErrorHandler $errorHandler)
        {
            $this->basePath = $basePath;
            $this->dotEnv = $dotEnv;
            $this->environment = $environment;
            $this->errorHandler = $errorHandler;
        }

        /** @inheritDoc */
        public function load(string ...$allowedDrivers): ApplicationInterface
        {
            if (empty($allowedDrivers)) {
                throw new NoDriverSelectedException();
            }

            $container = new Container();
            $container->add(DotEnv::class, $this->dotEnv);

            /// TODO: Register Exception Handler before, so we could nicely display exceptions in situation when driver
            ///       fail.

            /** @var DriverInterface $driver */
            $driver = $this->pickDriver($allowedDrivers, $container);

            $eh = $container->make($driver->defaultErrorHandler());
            $container->add(ExceptionHandlerInterface::class, $eh);

            $ehTrampoline = new ExceptionHandler($container);
            $container->add(ExceptionHandler::class, $ehTrampoline);

            set_exception_handler([$ehTrampoline, 'catchException']);

            return $driver->createApplication($container);
        }

        private function pickDriver(array $drivers, Container $container): DriverInterface
        {
            if (count($drivers) === 1) {
                /// TODO: If only one driver fails, return exception

                return $container->make($drivers[0]);
            }

            $pack = [$drivers[0]];
            $limit = $container->injectMethod($drivers[0], 'supportsEnvironment');

            for ($it = 1; $it < count($drivers); ++$it) {
                $current = $drivers[$it];

                $number = $container->injectMethod($current, 'supportsEnvironment');

                if ($limit === $number) {
                    $pack[] = $current;
                } else if ($limit < $number) {
                    $pack = [$current];
                    $limit = $number;
                }
            }

            if ($limit < 0) {
                throw new NoSuitableDriverSelectedException($pack, $limit);
            } else if (count($pack) > 1) {
                throw new AmbiguousDriverSelectionException($pack, $limit);
            }

            return $container->make($pack[0]);
        }
    }
