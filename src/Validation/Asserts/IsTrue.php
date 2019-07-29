<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts;

    use PsychoB\Framework\Validation\Asserts\Exception\ValueIsNotTrueAssert;

    final class IsTrue
    {
        public static function ensure($left, ?string $message = NULL)
        {
            if (!static::validate($left)) {
                if ($message === NULL) {
                    throw new ValueIsNotTrueAssert($left);
                } else {
                    throw new ValueIsNotTrueAssert($left, $message);
                }
            }
        }

        public static function validate($left): bool
        {
            return $left === true;
        }
    }
