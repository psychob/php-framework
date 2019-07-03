<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv;

    use PsychoB\Framework\Testing\TestCase;
    use Tests\PsychoB\Framework\Mocks\DotEnv\EnvTraitMock;

    class EnvTraitTest extends TestCase
    {
        /**
         * @var \Mockery\MockInterface|EnvTraitMock
         */
        private $parser;

        protected function setUp(): void
        {
            parent::setUp();

            $this->parser = \Mockery::mock(EnvTraitMock::class)
                                    ->makePartial();
        }

        public function provideParser()
        {
            return [
                ['string', 'string'],
                ['12', 12],
                ['true', true],
                ['false', false],
                ['NULL', NULL],
                ['null', NULL],
            ];
        }

        /** @dataProvider provideParser */
        public function testParser(string $value, $parsed)
        {
            $this->assertSame($parsed, $this->parser->parseVal($value));
        }
    }
