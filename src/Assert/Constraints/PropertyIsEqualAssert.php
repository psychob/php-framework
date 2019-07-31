<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\PropertyIsNotEqualException;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Ref;

    class PropertyIsEqualAssert
    {
        public static function ensure($obj, $name, $value, ?string $message = NULL): void
        {
            if (Arr::is($obj) && Arr::has($obj, $name)) {
                if ($obj[$name] === $value) {
                    return;
                }
            } else if ($obj instanceof \stdClass && $obj) {
                if (property_exists($obj, $name)) {
                    if ($obj->{$name} === $value) {
                        return;
                    }
                }
            } else if (is_object($obj)) {
                if (Ref::havePublicProperty($obj, $name)) {
                    if ($obj->{$name} === $value) {
                        return;
                    }
                } else if (Ref::haveAccessorTo($obj, $name)) {
                    if (Ref::getAccessorTo($obj, $name)() === $value) {
                        return;
                    }
                }
            }

            throw new PropertyIsNotEqualException($obj, $name, $value, $message);
        }
    }
