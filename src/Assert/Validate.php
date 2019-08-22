<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    use PsychoB\Framework\Assert\System\ValidateAssert;

    final class Validate
    {
        public static function __callStatic($name, $arguments)
        {
            return ValidateAssert::__callStatic($name, $arguments);
        }
    }
