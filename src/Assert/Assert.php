<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    use PsychoB\Framework\Assert\System\ArgumentAssert;
    use PsychoB\Framework\Assert\System\NormalAssert;

    final class Assert
    {
        public static function __callStatic($name, $arguments)
        {
            return NormalAssert::__callStatic($name, $arguments);
        }

        public static function arguments(?string $message = NULL,
            ?string $name = NULL,
            ?int $position = NULL): ArgumentAssert
        {
            return new ArgumentAssert($message, $position, $name);
        }
    }
