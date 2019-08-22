<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    final class ComparisionAssertProviders
    {
        public static function provideEqualValues(): array
        {
            return [
                [true, true],
                [true, 1],
                [true, -1],
                [true, "1"],
                [true, "-1"],
                [false, "0"],
                [false, ""],
                ["123", 123],
                [false, []],
            ];
        }

        public static function provideNotEqualValues(): array
        {
            return [
                [true, false],
                [true, "0"],
                [true, NULL],
                [false, true],
                [false, '1'],
            ];
        }

        public static function provideSameValues(): array
        {
            return [
                [true, true],
                [false, false],
                [1, 1],
            ];
        }

        public static function provideNotSameValues(): array
        {
            return [
                [true, 1],
                [true, -1],
                [true, "1"],
                [true, "-1"],
                [false, "0"],
                [false, ""],
                ["123", 123],
                [false, []],
            ];
        }

        public static function provideSmallerValues(): array
        {
            return [
                [0, 10],
                [0, '100'],
                [10, 100],
                [-30, 0],
            ];
        }

        public static function provideSmallerEqualValues(): array
        {
            return [
                [0, 10],
                [10, 10],
                [0, '100'],
                [100, '100'],
                [10, 100],
                [100, 100],
                [-30, 0],
                [-30, -30],
            ];
        }

        public function provideGreaterValues()
        {
            return [
                [10, 0],
                ['100', 0],
                [100, 10],
                [0, -30],
            ];
        }

        public function provideGreaterEqualValues()
        {
            return [
                [10, 0],
                [10, 10],
                ['100', 0],
                ['100', 100],
                [100, 10],
                [100, 100],
                [0, -30],
                [-30, -30],
            ];
        }
    }
