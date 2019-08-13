<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Math;

    use PsychoB\Framework\Math\Executor;
    use PsychoB\Framework\Math\Parser;
    use PsychoB\Framework\Testing\UnitTestCase;

    class ParserTest extends UnitTestCase
    {
        public function provideExpressions(): array
        {
            return [
                // simple numbers
                ['', '10'],
                ['', '13.37'],
                ['', '0xff00ff'],
                ['', '0b10101010001'],
                ['', '0o776'],
                ['', 'true'],
                ['', 'false'],

                // negative numbers
                ['', '-10'],
                ['', '-0b10100100101'],
            ];
        }

        /** @dataProvider provideExpressions */
        public function testExpressions(string $out, string $in): void
        {
            $this->assertSame($out, Executor::toString(Parser::parse($in)));
        }
    }
