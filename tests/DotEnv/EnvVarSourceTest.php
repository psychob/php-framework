<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv;

    use PsychoB\Framework\DotEnv\EnvVarSource;
    use PsychoB\Framework\Exceptions\EntryNotFoundException;
    use PsychoB\Framework\Testing\TestCase;

    class EnvVarSourceTest extends TestCase
    {
        /**
         * @var EnvVarSource
         */
        private $source;

        protected function setUp(): void
        {
            parent::setUp();

            $this->source = new EnvVarSource(false);
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
