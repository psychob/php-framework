<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Framework;

    use org\bovigo\vfs\vfsStream;
    use org\bovigo\vfs\vfsStreamDirectory;
    use PsychoB\Framework\Application\App;
    use PsychoB\Framework\Kernel;
    use PsychoB\Framework\Testing\UnitTestCase;

    class KernelTest extends UnitTestCase
    {
        private function inspectCurrentErrorHandler()
        {
            $old = set_error_handler(function () {});
            restore_error_handler();

            return $old;
        }

        private function inspectCurrentExceptionHandler()
        {
            $old = set_exception_handler(function () { });
            restore_exception_handler();

            return $old;
        }

        public function testKernelInit()
        {
            $vfs = $this->getVFS();

            $oldError = $this->inspectCurrentErrorHandler();
            $oldExcep = $this->inspectCurrentExceptionHandler();

            $kernel = new Kernel($vfs->url());
            $kernel->init();

            $currentError = $this->inspectCurrentErrorHandler();
            $currentExcep = $this->inspectCurrentExceptionHandler();

            $this->assertNotSame($oldError, $currentError, 'Error Handler miss match');
            $this->assertNotSame($oldExcep, $currentExcep, 'Exception Handler miss match');
        }

        public function testKernelMakeApp()
        {
            $vfs = $this->getVFS();

            $kernel = new Kernel($vfs->url());
            $kernel->init();
            $app = $kernel->createApp();

            $this->assertInstanceOf(App::class, $app);
        }

        public function testKernelDeInit()
        {
            $vfs = $this->getVFS();

            $oldError = $this->inspectCurrentErrorHandler();
            $oldExcep = $this->inspectCurrentExceptionHandler();

            $kernel = new Kernel($vfs->url());
            $kernel->init();
            $kernel->deinit();

            $currentError = $this->inspectCurrentErrorHandler();
            $currentExcep = $this->inspectCurrentExceptionHandler();

            $this->assertSame($oldError, $currentError, 'Error Handler miss match');
            $this->assertSame($oldExcep, $currentExcep, 'Exception Handler miss match');
        }

        /**
         * @return vfsStreamDirectory
         */
        protected function getVFS(): vfsStreamDirectory
        {
            $vfs = vfsStream::setup('/pbfw');

            return $vfs;
        }
    }
