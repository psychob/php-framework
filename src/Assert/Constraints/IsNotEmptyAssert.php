<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\ValueIsEmptyException;

    class IsNotEmptyAssert
    {
        public static function ensure($obj, ?string $message = NULL): void
        {
            if (empty($obj)) {
                throw new ValueIsEmptyException($obj, $message);
            }
        }
    }
