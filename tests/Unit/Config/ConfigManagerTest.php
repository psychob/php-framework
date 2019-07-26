<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Config;

    use PsychoB\Framework\Config\ConfigManager;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\Application\Directories\DirectoryManagerTraitMock;

    class ConfigManagerTest extends UnitTestCase
    {
        private $vfs;

        /** @var ConfigManager */
        private $config;

        protected function setUp(): void
        {
            parent::setUp();

            $this->vfs = $this->prepareVirtualFileSystem(['framework' => [
                'resources/config' => [
                    'framework.php' => "<?php return [ 'exists' => 42, ];",
                    'overlapping.php' => "<?php return [ 'framework' => 42, 'overlapped' => 42, ];",
                    'complex.php' => "<?php return [ 'overlapping' => [ 'foo' =>250, 'bar' => 'baz' ]];",
                ],
            ], 'app' => [
                'resources/config' => [
                    'app.php' => "<?php return [ 'exists' => 42, ];",
                    'overlapping.php' => "<?php return [ 'app' => 84, 'overlapped' => 112, ];",
                    'complex.php' => "<?php return [ 'overlapping' => [ 'foo' =>300, 'bar' => 'baz' ]];",
                ],
            ],]);

            $this->config = new ConfigManager(new DirectoryManagerTraitMock($this->getAppVfs(),
                $this->getFrameworkVfs()));
        }

        private function getFrameworkVfs(): string
        {
            return $this->vfs->url() . '/framework';
        }

        private function getAppVfs(): string
        {
            return $this->vfs->url() . '/app';
        }

        public function testLoadFromEmpty()
        {
            $this->assertNull($this->config->get('non-existing.foo'));
        }

        public function testLoadFromNotOverlappingFile()
        {
            $this->assertSame(42, $this->config->get('framework.exists'));
            $this->assertSame(42, $this->config->get('app.exists'));

            $this->assertSame(84, $this->config->get('framework.not-exists', 84));
            $this->assertSame(84, $this->config->get('app.not-exists', 84));
        }

        public function testLoadFromOverlappingFile()
        {
            $this->assertSame(42, $this->config->get('overlapping.framework'));
            $this->assertSame(84, $this->config->get('overlapping.app'));
            $this->assertSame(112, $this->config->get('overlapping.overlapped'));
        }

        public function testLoadComplexFromOverlappingFile()
        {
            $this->assertSame(300, $this->config->get('complex.overlapping.foo'));
        }
    }
