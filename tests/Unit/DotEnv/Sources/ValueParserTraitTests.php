<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DotEnv\Sources;

    use PsychoB\Framework\Testing\CoreTestCase;
    use Tests\PsychoB\Framework\Mocks\DotEnv\Sources\ValueParserMock;

    class ValueParserTraitTests extends CoreTestCase
    {
        /**
         * @var \Mockery\MockInterface|ValueParserMock
         */
        private $parser;

        protected function setUp(): void
        {
            parent::setUp();

            $this->parser = \Mockery::mock(ValueParserMock::class)
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
