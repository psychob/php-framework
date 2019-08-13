<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\ObjectProperties;

    class IsEmptyAssert
    {
        public static function ensure($obj, ?string $message = NULL): void
        {
            if (!empty($obj)) {
                throw new ValueIsNotEmptyException($obj, $message);
            }
        }
    }
