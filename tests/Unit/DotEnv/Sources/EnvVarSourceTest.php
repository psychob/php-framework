<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DotEnv\Sources;

    use PsychoB\Framework\DotEnv\Exceptions\EnvNotFoundException;
    use PsychoB\Framework\DotEnv\Sources\EnvVarSource;
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

            $_ENV = [
                'ABC' => 'DEF',
                'EFG' => 'HIJ',
            ];

            $this->source = new EnvVarSource(false);
        }

        protected function tearDown(): void
        {
            $_ENV = [];

            parent::tearDown();
        }

        public function testHas()
        {
            $this->assertTrue($this->source->has('ABC'));
            $this->assertFalse($this->source->has('DEF'));
        }

        public function testGetter()
        {
            $this->assertSame('HIJ', $this->source->get('EFG'));
        }

        public function testGetterNotExist()
        {
            $this->expectException(EnvNotFoundException::class);

            $this->source->get('IJK');
        }
    }
