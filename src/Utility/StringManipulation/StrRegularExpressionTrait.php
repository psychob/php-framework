<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility\StringManipulation;

    trait StrRegularExpressionTrait
    {
        /**
         * Match regular expression to string
         *
         * @param string $subject
         * @param string $regularExpression
         *
         * @return mixed[]|false
         */
        public static function match(string $subject, string $regularExpression)
        {
            $matched = [];

            if (preg_match($regularExpression, $subject, $matched)) {
                return $matched;
            }

            return false;
        }

        public static function matching(string $subject, string $regularExpression): bool
        {
            return preg_match($regularExpression, $subject) === 1;
        }
    }
