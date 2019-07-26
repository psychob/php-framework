<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Config;

    use org\bovigo\vfs\vfsStream;
    use org\bovigo\vfs\vfsStreamDirectory;
    use org\bovigo\vfs\vfsStreamFile;
    use PsychoB\Framework\Config\ConfigManager;
    use PsychoB\Framework\Testing\UnitTestCase;

    class ConfigManagerTest extends UnitTestCase
    {
        private $vfs;

        protected function setUp(): void
        {
            parent::setUp();

            $this->vfs = vfsStream::setup('/');
            $framework = new vfsStreamDirectory('framework');
            $app = new vfsStreamDirectory('app');

            $framework->at($this->vfs);
            $app->at($this->vfs);

            $frameworkConfig = new vfsStreamFile('framework.php');
            $frameworkConfig->at($framework)->setContent(<<<PHP
<?php
    return [
        'exists' => 42,
    ];
PHP
            );
            (new vfsStreamFile('overlapping.php'))->at($framework)->setContent(<<<PHP
<?php
    return [
        'framework' => 42,
        
        'overlapped' => 42,
    ];
PHP
            );
            (new vfsStreamFile('complex.php'))->at($framework)->setContent(<<<PHP
<?php
    return [
        'overlapping' => [
            'foo' => 250,
            'bar' => 'baz',
        ],
    ];
PHP
            );

            $appConfig = new vfsStreamFile('app.php');
            $appConfig->at($app)->setContent(<<<PHP
<?php
    return [
        'exists' => 42,
    ];
PHP
            );
            (new vfsStreamFile('overlapping.php'))->at($app)->setContent(<<<PHP
<?php
    return [
        'app' => 84,
        
        'overlapped' => 112,
    ];
PHP
            );
            (new vfsStreamFile('complex.php'))->at($app)->setContent(<<<PHP
<?php
    return [
        'overlapping' => [
            'foo' => 300,
            'bar' => 'baz',
        ],
    ];
PHP
            );
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
            $config = new ConfigManager($this->getFrameworkVfs(), $this->getAppVfs());

            $this->assertNull($config->get('non-existing.foo'));
        }

        public function testLoadFromNotOverlappingFile()
        {
            $config = new ConfigManager($this->getFrameworkVfs(), $this->getAppVfs());

            $this->assertSame(42, $config->get('framework.exists'));
            $this->assertSame(42, $config->get('app.exists'));

            $this->assertSame(84, $config->get('framework.not-exists', 84));
            $this->assertSame(84, $config->get('app.not-exists', 84));
        }

        public function testLoadFromOverlappingFile()
        {
            $config = new ConfigManager($this->getFrameworkVfs(), $this->getAppVfs());

            $this->assertSame(42, $config->get('overlapping.framework'));
            $this->assertSame(84, $config->get('overlapping.app'));
            $this->assertSame(112, $config->get('overlapping.overlapped'));
        }

        public function testLoadComplexFromOverlappingFile()
        {
            $config = new ConfigManager($this->getFrameworkVfs(), $this->getAppVfs());

            $this->assertSame(300, $config->get('complex.overlapping.foo'));
        }
    }
