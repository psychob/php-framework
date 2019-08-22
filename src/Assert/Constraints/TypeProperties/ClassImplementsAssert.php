<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\TypeProperties;

    use PsychoB\Framework\Utility\Ref;

    class ClassImplementsAssert
    {
        public static function classImplements($class, $interface, ?string $message = NULL): void
        {
            if (!Ref::implements($class, $interface)) {
                throw new ClassDoesNotImplementInterfaceException($class, $interface, $message);
            }
        }
    }
