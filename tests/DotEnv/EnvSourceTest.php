<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv;

    use org\bovigo\vfs\vfsStream;
    use org\bovigo\vfs\vfsStreamFile;
    use PsychoB\Framework\DotEnv\EnvSource;
    use PsychoB\Framework\DotEnv\EnvVarSource;
    use PsychoB\Framework\Exceptions\EntryNotFoundException;
    use PsychoB\Framework\Testing\TestCase;

    class EnvSourceTest extends TestCase
    {
        /**
         * @var EnvVarSource
         */
        private $source;

        protected function setUp(): void
        {
            parent::setUp();

            $directory = vfsStream::setup('test');
            $file = new vfsStreamFile('.env');
            $file->setContent(<<<CONF
# This line will only have comment
DEFINE=WITH_SOMETHING # This line will have definition
DEFINE_2=WITHOUT

ABC=DEF
GHI=JKL

JKL=2

CONF
);
            $directory->addChild($file);

            $this->source = new EnvSource(null, $file->url(), false);
        }

        public function testExists()
        {
            $this->assertTrue($this->source->has('DEFINE'));
            $this->assertTrue($this->source->has('DEFINE_2'));
            $this->assertTrue($this->source->has('ABC'));
            $this->assertTrue($this->source->has('GHI'));
            $this->assertTrue($this->source->has('JKL'));
            $this->assertFalse($this->source->has('DEF'));
            $this->assertFalse($this->source->has('WITHOUT'));
        }

        public function testExtract()
        {
            $this->assertSame('WITH_SOMETHING', $this->source->get('DEFINE'));
            $this->assertSame('WITHOUT', $this->source->get('DEFINE_2'));
            $this->assertSame('DEF', $this->source->get('ABC'));
            $this->assertSame('JKL', $this->source->get('GHI'));
            $this->assertSame(2, $this->source->get('JKL'));
        }

        public function testDosentExist()
        {
            $this->expectException(EntryNotFoundException::class);

            $this->source->get('DEF');
        }
    }