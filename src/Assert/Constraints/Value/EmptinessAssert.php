<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Value;

    class EmptinessAssert
    {
        public static function isEmpty($value, ?string $message = NULL): void
        {
            if (!empty($value)) {
                throw new ValueIsFullException($value, $message);
            }
        }

        public static function isNotEmpty($value, ?string $message = NULL): void
        {
            if (empty($value)) {
                throw new ValueIsEmptyException($value, $message);
            }
        }
    }
