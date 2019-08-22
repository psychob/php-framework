<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert;

    class ArrayAssertProvider
    {
        public function provideWithKeys(): array
        {
            return [
                [['a' => 'b'], 'a'],
                [[1 => 'b'], 1],
            ];
        }

        public function provideWithoutKeys(): array
        {
            return [
                [['a' => 'b'], 'c'],
                [[1 => 'b'], 2],
            ];
        }
    }
