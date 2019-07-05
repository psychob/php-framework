<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Kernel;

    use org\bovigo\vfs\vfsStream;
    use PHPUnit\Framework\TestCase;
    use PsychoB\Framework\Kernel\Environment;
    use PsychoB\Framework\Kernel\ErrorHandling\ErrorHandler;
    use PsychoB\Framework\Kernel\Kernel;

    class KernelTest extends TestCase
    {
        protected function getVfs()
        {
            return vfsStream::setup();
        }

        /** @runInSeparateProcess */
        public function testInit()
        {
            $vfs = $this->getVfs();

            $this->assertInstanceOf(Environment::class, Kernel::boot($vfs->url()));

            $handler = set_error_handler(NULL);
            $this->assertIsArray($handler, 'Error Handler is not set');
            $this->assertInstanceOf(ErrorHandler::class, $handler[0], 'Error Handler is not set');
            $this->assertEquals('throwException', $handler[1]);
        }
    }
