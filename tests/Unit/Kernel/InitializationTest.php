<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Kernel;

    use org\bovigo\vfs\vfsStream;
    use PHPUnit\Framework\TestCase;
    use PsychoB\Framework\Kernel\Environment\EnvironmentInterface;
    use PsychoB\Framework\Kernel\Kernel;

    class InitializationTest extends TestCase
    {
        protected function getVfs()
        {
            return vfsStream::setup();
        }

        public function testInit()
        {
            $vfs = $this->getVfs();

            $this->assertInstanceOf(EnvironmentInterface::class, Kernel::boot($vfs->url()));
        }
    }
