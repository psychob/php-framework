<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\ArrayProperties;

    use PsychoB\Framework\Utility\Arr;

    class ArrayAssert
    {
        public static function hasKey($arr, $element, ?string $message = NULL): void
        {
            if (!Arr::has($arr, $element)) {
                throw new ArrayDontHaveKeyException($arr, $element, $message);
            }
        }

        public static function dontHaveKey($arr, $element, ?string $message = NULL): void
        {
            if (Arr::has($arr, $element)) {
                throw new ArrayHasKeyException($arr, $element, $message);
            }
        }
    }
