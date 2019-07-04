<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv\Sources;

    use PsychoB\Framework\DotEnv\Sources\GetEnvSource;
    use PsychoB\Framework\Exceptions\EntryNotFoundException;
    use PsychoB\Framework\Testing\TestCase;

    class GetEnvSourceTest extends TestCase
    {
        /**
         * @var GetEnvSource
         */
        private $source;

        protected function setUp(): void
        {
            parent::setUp();

            $this->source = new GetEnvSource(false);
        }

        /** @runInSeparateProcess  */
        public function testHas()
        {
            putenv('ABC=DEF');

            $this->assertTrue($this->source->has('ABC'));
            $this->assertFalse($this->source->has('DEF'));
        }

        /** @runInSeparateProcess  */
        public function testGetter()
        {
            putenv('EFG=HIJ');

            $this->assertSame('HIJ', $this->source->get('EFG'));
        }

        /** @runInSeparateProcess  */
        public function testGetterNotExist()
        {
            $this->expectException(EntryNotFoundException::class);

            $this->source->get('EFG');
        }
    }
