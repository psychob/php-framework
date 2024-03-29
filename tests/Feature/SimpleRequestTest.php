<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Feature;

    use org\bovigo\vfs\vfsStream;
    use PsychoB\Framework\Kernel;
    use PsychoB\Framework\Testing\UnitTestCase;

    /** @runTestsInSeparateProcesses */
    class SimpleRequestTest extends UnitTestCase
    {
        public function test()
        {
            $vfs = $this->prepareVirtualFileSystem([
                'framework' => [
                    'resources/config' => [

                    ],
                ],
            ]);

            $kernel = Kernel::make($vfs->url() . '/framework');
            $kernel->init();
            $app = $kernel->createApp();

            $app->setup();
            $kernel->deinit();

            $this->assertTrue(true);
        }
    }
