<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility\StringManipulation;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Utility\Str;

    trait StrInfoTrait
    {
        public static function is($str): bool
        {
            return is_string($str);
        }

        public static function len(string $str): int
        {
            return strlen($str);
        }

        public static function first(string $str): string
        {
            Assert::arguments('String cannot be empty', 'str', 1)
                  ->isNotEmpty($str);

            return $str[0];
        }

        public static function last(string $str): string
        {
            Assert::arguments('String cannot be empty', 'str', 1)
                  ->isNotEmpty($str);

            return $str[Str::len($str) - 1];
        }

        public static function tryFirst(string $str): ?string
        {
            if (empty($str)) {
                return NULL;
            }

            return self::first($str);
        }

        public static function tryLast(string $str): ?string
        {
            if (empty($str)) {
                return NULL;
            }

            return self::last($str);
        }
    }
