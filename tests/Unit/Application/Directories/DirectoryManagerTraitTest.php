<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Application\Directories;

    use org\bovigo\vfs\vfsStreamDirectory;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\Application\Directories\DirectoryManagerTraitMock;

    class DirectoryManagerTraitTest extends UnitTestCase
    {
        /**  @var vfsStreamDirectory */
        private $vfs;

        /**  @var DirectoryManagerTraitMock */
        private $discovery;

        public function setUp(): void
        {
            parent::setUp();

            $this->vfs = $this->prepareVirtualFileSystem([
                'framework/resources' => [
                    //
                ],
                'app/resources' => [
                    //
                ],
            ]);

            $this->discovery = new DirectoryManagerTraitMock($this->vfs->url() . '/app',
                $this->vfs->url() . '/framework');
        }

        public function testGetters()
        {
            $this->assertSame('vfs:///app', $this->discovery->getApplicationDirectory());
            $this->assertSame('vfs:///framework', $this->discovery->getFrameworkDirectory());
        }

        public function testAddingDirectory()
        {
            $this->discovery->addDirectory('foo', 'bar');

            $this->assertArrayElementsContainsValues(['bar'], $this->discovery->getBaseDirectories());
            $this->assertArrayElementsContainsValues(['bar'], $this->discovery->getModuleDirectories('foo'));
        }
    }
