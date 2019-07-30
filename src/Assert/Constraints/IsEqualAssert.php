<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\ValueIsNotEqualException;

    class IsEqualAssert
    {
        public static function ensure($left, $right, ?string $message = NULL): void
        {
            if ($left !== $right) {
                throw new ValueIsNotEqualException($left, $right, $message);
            }
        }
    }
