<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts;

    use PsychoB\Framework\Validation\Asserts\Exception\ValuesAreNotEqualAssert;

    final class IsEqual
    {
        public static function ensure($left, $right)
        {
            if (!static::validate($left, $right)) {
                throw new ValuesAreNotEqualAssert($left, $right);
            }
        }

        public static function validate($left, $right): bool
        {
            return $left === $right;
        }
    }
