<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Math;

    use PsychoB\Framework\Testing\UnitTestCase;

    class EngineTest extends UnitTestCase
    {
        public function provideEngine(): array
        {
            return [
                // literals
                [0, '0'],
                [42, '42'],

                // simple expression
                [4, '2 + 2'],
                [4, '2+2'],
                [4, "\t2\t+\t2\t"],
                [6, '2+2*2'],
                [8, '(2+2)*2'],
                [20, '4+4*4'],

                // variables
                [42, 'x', ['x' => 42]],
            ];
        }

        /** @dataProvider provideEngine */
        public function testEngine($out, string $in, array $var = []): void
        {
            $this->assertSame($out, Engine::compute($in, $var));
        }
    }
