<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Value;

    class ComparisionAssert
    {
        public static function isSame($left, $right, ?string $message = NULL): void
        {
            if ($left !== $right) {
                throw new ValuesAreDifferentException($left, $right, true, $message);
            }
        }

        public static function isNotSame($left, $right, ?string $message = NULL): void
        {
            if ($left === $right) {
                throw new ValuesAreSameException($left, $right, true, $message);
            }
        }

        public static function isEqual($left, $right, ?string $message = NULL): void
        {
            if ($left != $right) {
                throw new ValuesAreDifferentException($left, $right, false, $message);
            }
        }

        public static function isNotEqual($left, $right, ?string $message = NULL): void
        {
            if ($left == $right) {
                throw new ValuesAreSameException($left, $right, false, $message);
            }
        }
    }
