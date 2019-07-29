<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    class Assert
    {
        public static function isTrue($expr, ?string $customExceptionClass = NULL, ?string $message = NULL): void
        {
            if ($expr === false) {
                throw new \RuntimeException("Assertion failed");
            }
        }

        public static function isFalse($expr, ?string $customExceptionClass = NULL, ?string $message = NULL): void
        {
            if ($expr === true) {
                throw new \RuntimeException("Assertion failed");
            }
        }
    }
