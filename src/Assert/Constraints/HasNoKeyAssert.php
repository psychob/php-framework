<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\ArrayHasKeyException;
    use PsychoB\Framework\Utility\Arr;

    class HasNoKeyAssert
    {
        public static function ensure($arr, $key, ?string $message = NULL): void
        {
            if (Arr::has($arr, $key)) {
                throw new ArrayHasKeyException($arr, $key, $message);
            }
        }
    }
