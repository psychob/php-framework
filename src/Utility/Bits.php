<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    class Bits
    {
        public static function has(int $number, int $flag): bool
        {
            return ($number & $flag) === $flag;
        }
    }
