<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Kernel;

    use Mockery;
    use org\bovigo\vfs\vfsStream;
    use PsychoB\DependencyInjection\Container;
    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\EnvSourceFactory;
    use PsychoB\Framework\Kernel\Driver\ApplicationInterface;
    use PsychoB\Framework\Kernel\Driver\DriverInterface;
    use PsychoB\Framework\Kernel\Environment;
    use PsychoB\Framework\Kernel\ErrorHandling\ErrorHandler;
    use PsychoB\Framework\Kernel\ErrorHandling\ExceptionHandler;
    use PsychoB\Framework\Kernel\ErrorHandling\ExceptionHandlerInterface;
    use PsychoB\Framework\Kernel\Exception\AmbiguousDriverSelectionException;
    use PsychoB\Framework\Kernel\Exception\NoDriverSelectedException;
    use PsychoB\Framework\Kernel\Exception\NoSuitableDriverSelectedException;
    use PsychoB\Framework\Testing\CoreTestCase;

    class EnvironmentTest extends CoreTestCase
    {
        protected function getVfs()
        {
            return vfsStream::setup();
        }

        private function createEmptyDriver(int $level): DriverInterface
        {
            $mock = Mockery::namedMock('EmptyDriverInterface' . md5(uniqid()), DriverInterface::class);
            $mock->shouldReceive('supportsEnvironment')->andReturn($level);

            return $mock;
        }

        /** @runInSeparateProcess */
        public function testLoadOne()
        {
            $vfs = $this->getVfs();

            $environment = new Environment($vfs->url(),
                                           new DotEnv($vfs->url(), EnvSourceFactory::envVar(false)),
                                           'testing',
                                           new ErrorHandler()
            );

            $appMock = Mockery::mock(ApplicationInterface::class);
            $exceptionHandlerClass = get_class(Mockery::mock(ExceptionHandlerInterface::class));

            $perfectDriver = Mockery::mock(DriverInterface::class);
            $perfectDriver->shouldReceive('defaultExceptionHandler')
                          ->andReturn($exceptionHandlerClass);
            $perfectDriver->shouldReceive('createApplication')->withArgs(function ($container) {
                $this->assertInstanceOf(Container::class, $container);

                return true;
            })->andReturn($appMock);

            $app = $environment->load(get_class($perfectDriver));
            $this->assertInstanceOf(ApplicationInterface::class, $app);
            $this->assertSame($appMock, $app);

            $lastExceptionHandler = set_exception_handler(NULL);
            $this->assertIsArray($lastExceptionHandler);
            $this->assertInstanceOf(ExceptionHandler::class, $lastExceptionHandler[0]);
            $this->assertSame('catchException', $lastExceptionHandler[1]);
        }

        /** @runInSeparateProcess */
        public function testLoadNone()
        {
            $vfs = $this->getVfs();

            $environment = new Environment($vfs->url(),
                                           new DotEnv($vfs->url(), EnvSourceFactory::envVar(false)),
                                           'testing',
                                           new ErrorHandler()
            );

            $this->expectException(NoDriverSelectedException::class);

            $environment->load();
        }

        public function testLoadNoSuitable()
        {
            $vfs = $this->getVfs();

            $environment = new Environment($vfs->url(),
                                           new DotEnv($vfs->url(), EnvSourceFactory::envVar(false)),
                                           'testing',
                                           new ErrorHandler()
            );

            $drivers = [
                get_class($this->createEmptyDriver(-30)),
                get_class($this->createEmptyDriver(-10)),
                get_class($this->createEmptyDriver(-10)),
                get_class($this->createEmptyDriver(-1)),
            ];

            $this->expectException(NoSuitableDriverSelectedException::class);
            $environment->load(...$drivers);
        }

        public function testLoadTwoSuitable()
        {
            $vfs = $this->getVfs();

            $environment = new Environment($vfs->url(),
                                           new DotEnv($vfs->url(), EnvSourceFactory::envVar(false)),
                                           'testing',
                                           new ErrorHandler()
            );

            $drivers = [
                get_class($this->createEmptyDriver(10)),
                get_class($this->createEmptyDriver(20)),
                get_class($this->createEmptyDriver(25)),
                get_class($this->createEmptyDriver(25)),
            ];

            $this->expectException(AmbiguousDriverSelectionException::class);
            $environment->load(...$drivers);
        }
    }
