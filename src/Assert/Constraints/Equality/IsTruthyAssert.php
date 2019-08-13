<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Equality;

    class IsTruthyAssert
    {
        public static function ensure($value, ?string $message = null)
        {
            if ($value != true) {
                throw new ValueIsNotTruthyException($value, $message);
            }
        }
    }
