<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    use PsychoB\Framework\Assert\System\NormalAssert;

    class Assert
    {
        public static function __callStatic($name, $arguments)
        {
            return NormalAssert::__callStatic($name, $arguments);
        }
    }
