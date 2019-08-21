<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Other;

    class UnreachableAssert
    {
        public static function ensure(?string $message = null): void
        {
            throw new UnreachableAssertException($message);
        }
    }
