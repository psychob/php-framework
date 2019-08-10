<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    class EnumOneOfAssert
    {
        public static function ensure($value, array $possibilities, ?string $message = NULL): void
        {
            foreach ($possibilities as $name => $value) {
                if ($value === $value) {
                    return;
                }
            }

            throw new EnumNotOneOfException($value, $possibilities, $message);
        }
    }
