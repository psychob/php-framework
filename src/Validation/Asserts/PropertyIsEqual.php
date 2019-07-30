<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts;

    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Ref;
    use PsychoB\Framework\Validation\Asserts\Exception\BaseAssert;
    use PsychoB\Framework\Validation\Asserts\Exception\PropertyIsEqualAssert;
    use stdClass;

    final class PropertyIsEqual
    {
        public static function ensure($obj, $property, $value, ?string $message = NULL)
        {
            if (Arr::is($obj)) {
                if (Arr::has($obj, $property)) {
                    if ($obj[$property] === $value) {
                        return;
                    }
                }
            } else if ($obj instanceof stdClass && property_exists($obj, $property)) {
                if ($obj->{$property} === $value) {
                    return;
                }
            } else {
                if (Ref::havePublicProperty($obj, $property)) {
                    if ($obj->{$property} === $value) {
                        return;
                    }
                }

                if (Ref::haveAccessorTo($obj, $property)) {
                    if (Ref::getAccessorTo($obj, $property)() === $value) {
                        return;
                    }
                }
            }

            if ($message) {
                throw new PropertyIsEqualAssert($obj, $property, $value, $message);
            } else {
                throw new PropertyIsEqualAssert($obj, $property, $value);
            }
        }

        public static function validate($obj, $property, $value): bool
        {
            if (Arr::is($obj)) {
                if (Arr::has($obj, $property)) {
                    return $obj[$property] === $value;
                } else {
                    return false;
                }
            } else if ($obj instanceof stdClass && property_exists($obj, $property)) {
                return $obj->{$property} === $value;
            } else {
                if (Ref::havePublicProperty($obj, $property)) {
                    return $obj->{$property} === $value;
                }

                if (Ref::haveAccessorTo($obj, $property)) {
                    return Ref::getAccessorTo($obj, $property)() === $value;
                }
            }

            return false;
        }
    }
