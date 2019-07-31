<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\UnreachableException;

    class UnreachableAssert
    {
        public static function ensure(?string $message = NULL): void
        {
            throw new UnreachableException($message);
        }
    }
