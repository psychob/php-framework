<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility\StringManipulation;

    use PsychoB\Framework\Utility\Str;

    trait StrCompareTrait
    {
        public static function equals(string $left,
            string $right,
            ?int $length = NULL,
            ?int $leftStart = NULL,
            ?int $rightStart = NULL,
            bool $caseSensitive = true): bool
        {
            return self::compare($left, $right, $length, $leftStart, $rightStart, $caseSensitive) === 0;
        }

        /**
         * Compare two strings to determine which one is "larger", "smaller" or equal
         *
         * @param string   $left          Left String
         * @param string   $right         Right String
         * @param int|null $length        Length
         * @param int|null $leftStart     Where to start with left string
         * @param int|null $rightStart    Where to start with right string
         * @param bool     $caseSensitive Should this comparision be done as case sensitive
         *
         * @return int
         */
        public static function compare(string $left,
            string $right,
            ?int $length = NULL,
            ?int $leftStart = NULL,
            ?int $rightStart = NULL,
            bool $caseSensitive = true): int
        {
            if ($length === NULL && $leftStart === NULL && $rightStart === NULL) {
                if ($caseSensitive) {
                    return self::compareFullCaseSensitive($left, $right);
                } else {
                    return self::compareFullCaseInsensitive($left, $right);
                }
            } else if ($leftStart === NULL && $rightStart === NULL) {
                if ($caseSensitive) {
                    return self::compareStartsWithCaseSensitive($left, $right, $length);
                } else {
                    return self::compareStartsWithCaseInsensitive($left, $right, $length);
                }
            } else {
                $leftStart = $leftStart ?? 0;
                $rightStart = $rightStart ?? 0;

                if ($length === NULL) {
                    if ($caseSensitive) {
                        return self::compareOffsetFullCaseSensitive($left, $right, $leftStart, $rightStart);
                    } else {
                        return self::compareOffsetFullCaseInsensitive($left, $right, $leftStart, $rightStart);
                    }
                } else {
                    if ($caseSensitive) {
                        return self::compareOffsetPartCaseSensitive($left, $right, $length, $leftStart, $rightStart);
                    } else {
                        return self::compareOffsetPartCaseInsensitive($left, $right, $length, $leftStart, $rightStart);
                    }
                }
            }
        }

        public static function compareFullCaseSensitive(string $left, string $right): int
        {
            return $left <=> $right;
        }

        public static function compareFullCaseInsensitive(string $left, string $right): int
        {
            return strcasecmp($left, $right);
        }

        public static function compareStartsWithCaseSensitive(string $left, string $right, int $length): int
        {
            return strncmp($left, $right, $length);
        }

        public static function compareStartsWithCaseInsensitive(string $left, string $right, int $length): int
        {
            return strncasecmp($left, $right, $length);
        }

        public static function compareOffsetFullCaseSensitive(string $left,
            string $right,
            int $leftStart,
            int $rightStart): int
        {
            [$isFailed, $left, $right] = self::prepareCompareOffsetPart($left, $right, Str::len($left) - $leftStart,
                $leftStart, $rightStart);

            if ($isFailed !== NULL) {
                return $isFailed;
            }

            return self::compareFullCaseSensitive($left, $right);
        }

        public static function compareOffsetFullCaseInsensitive(string $left,
            string $right,
            int $leftStart,
            int $rightStart): int
        {
            [$isFailed, $left, $right] = self::prepareCompareOffsetPart($left, $right, Str::len($left) - $leftStart,
                $leftStart, $rightStart);

            if ($isFailed !== NULL) {
                return $isFailed;
            }

            return self::compareFullCaseInsensitive($left, $right);
        }

        public static function compareOffsetPartCaseSensitive(string $left,
            string $right,
            int $length,
            int $leftStart,
            int $rightStart): int
        {
            [$isFailed, $left, $right] = self::prepareCompareOffsetPart($left, $right, $length, $leftStart,
                $rightStart);

            if ($isFailed !== NULL) {
                return $isFailed;
            }

            return self::compareFullCaseSensitive($left, $right);
        }

        public static function compareOffsetPartCaseInsensitive(string $left,
            string $right,
            int $length,
            int $leftStart,
            int $rightStart): int
        {
            [$isFailed, $left, $right] = self::prepareCompareOffsetPart($left, $right, $length, $leftStart,
                $rightStart);

            if ($isFailed !== NULL) {
                return $isFailed;
            }

            return self::compareFullCaseInsensitive($left, $right);
        }

        private static function prepareCompareOffsetPart(string $left,
            string $right,
            int $length,
            int $lStart,
            int $rStart): array
        {
            $lLen = Str::len($left);
            $rLen = Str::len($right);

            if ($lLen - $lStart < $length) {
                return [-1, NULL, NULL];
            }

            if ($rLen - $rStart < $length) {
                return [1, NULL, NULL];
            }

            // at this stage we will know that we could fit comparable string into both strings
            $leftTrimmed = Str::substr($left, $lStart, $length);
            $rightTrimmed = Str::substr($right, $rStart, $length);

            return [NULL, $leftTrimmed, $rightTrimmed];
        }
    }
