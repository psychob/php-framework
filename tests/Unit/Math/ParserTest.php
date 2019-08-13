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
                ['int(42)', '42'],
                ['float(42.42)', '42.42'],
                ['+(int(42), float(42.42))', '42 + 42.42'],
                ['+(int(2), *(int(2), int(2)))', '2 + 2 * 2'],
                ['-(+(int(2), *(/(int(2), float(7.5)), int(3))), int(2))', '2 + 2 / 7.5 * 3 - 2'],

                // negative signs
                ['int(-2)', '-2'],
                ['int(-2)', '-2 + -2 * -2'],

                // parens
                ['*(+(int(2), int(2)), int(2))', '(2 + 2) * 2'],
                ['+(int(2), *(int(2), +(int(2), int(2))))', '2 + 2 * (2 + 2)'],
                ['+(int(2), int(2))', '(2 + 2)'],
                ['+(int(2), int(2))', ' (2 + 2)'],
                ['+(int(2), int(2))', ' ( 2 + 2)'],
                ['+(int(2), int(2))', '(2 + 2 )'],
                ['+(int(2), int(2))', '(2 + 2 ) '],
                ['+(int(2), int(2))', '( 2 + 2 ) '],
                ['+(int(2), int(2))', ' ( 2 + 2 ) '],
                ['', '(2 + (2 * (2 + (2))))'],
                ['', '(2 + (2 * (2 + 2)))'],
                ['+(int(2), (+(int(2), (+(int(2), int(2))))))', '2 + (2 + (2 + 2))'],
            ];
        }

        /** @dataProvider provideExpressions */
        public function testExpressions(string $out, string $in): void
        {
            $this->assertSame($out, Executor::toString(Parser::parse($in)));
        }
    }
