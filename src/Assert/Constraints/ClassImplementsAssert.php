<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\ClassDoesNotImplementInterfaceException;
    use PsychoB\Framework\Utility\Ref;

    class ClassImplementsAssert
    {
        public static function ensure($obj, $interface, ?string $message = NULL): void
        {
            if (!Ref::implements($obj, $interface)) {
                throw new ClassDoesNotImplementInterfaceException($obj, $interface, $message);
            }
        }
    }
