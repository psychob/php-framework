<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Utility;

    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class StrTest extends UnitTestCase
    {
        /** @dataProvider provideToRepr */
        public function testToRepr($obj, string $expectedResult): void
        {
            $this->assertSame($expectedResult, Str::toRepr($obj));
        }

        public function provideToRepr(): array
        {
            return [
                [NULL, "null"],
                [true, "bool(true)"],
                [10, "integer(10)"],
                [21.37, "double(21.37)"],
                ['str', "string(str)"],
                [[], "array"],
                [$this, static::class],
            ];
        }
    }
