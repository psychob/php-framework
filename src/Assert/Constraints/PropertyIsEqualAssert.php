<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Utility\Arr;

    class PropertyIsEqualAssert
    {
        public static function ensure($obj, $name, $value, ?string $message = NULL): void
        {
            if (Arr::is($obj) && Arr::has($obj, $name)) {
                if ($obj[$name] !== $value) {
                    throw new PropertyIsNotEqualException($obj, $name, $value, $message);
                }
            }
        }
    }
