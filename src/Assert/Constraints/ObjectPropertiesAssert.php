<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Assert\Exception\ObjectPropertiesDoesntMatchException;

    class ObjectPropertiesAssert
    {
        public static function ensure($obj, $props, ?string $message = NULL): void
        {
            try {
                foreach ($props as $name => $value) {
                    PropertyIsEqualAssert::ensure($obj, $name, $value);
                }
            } catch (AssertionException $a) {
                throw new ObjectPropertiesDoesntMatchException($obj, $props, $message, $a);
            }
        }
    }
