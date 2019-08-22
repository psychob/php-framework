<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\EnumProperties;

    use PsychoB\Framework\Utility\Arr;

    class EnumAssert
    {
        public static function oneOf($value, array $values, ?string $message = NULL): void
        {
            if (!Arr::contains($values, $value)) {
                throw new ValueIsNotEnumException($value, $values, $message);
            }
        }

        public static function combinationOf($value, array $values, ?string $message = NULL): void
        {
            foreach ($values as $name => $val) {
                if (($value & $val) === $val) {
                    $value ^= $val;
                }

                if ($value === 0) {
                    return;
                }
            }

            throw new ValueIsNotCombinationEnumException($value, $values, $message);
        }
    }
