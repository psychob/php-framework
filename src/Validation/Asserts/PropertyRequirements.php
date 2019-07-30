<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts;

    use PsychoB\Framework\Validation\Asserts\Exception\PropertyIsEqualAssert;
    use PsychoB\Framework\Validation\Asserts\Exception\PropertyRequirementsAssert;

    final class PropertyRequirements
    {
        public static function ensure($obj, array $property, ?string $message = NULL)
        {
            try {
                foreach ($property as $name => $value) {
                    PropertyIsEqual::ensure($obj, $name, $value);
                }
            } catch (PropertyIsEqualAssert $e) {
                throw new PropertyRequirementsAssert($obj, $property, $e);
            }
        }

        public static function validate($obj, $property): bool
        {
            foreach ($property as $name => $value) {
                if (!PropertyIsEqual::validate($obj, $name, $value)) {
                    return false;
                }
            }

            return true;
        }
    }
