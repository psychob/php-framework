<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\TypeProperties;

    use PsychoB\Framework\Assert\Constraints\ObjectPropertiesAssert;
    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeRequirementException;

    class TypeHasAssert
    {
        public static function ensure($obj, $type, $props, ?string $message = NULL): void
        {
            try {
                TypeIsAssert::ensure($obj, $type);
                ObjectPropertiesAssert::ensure($obj, $props);
            } catch (AssertionException $e) {
                throw new TypeRequirementException($obj, $type, $props, $message, $e);
            }
        }
    }
