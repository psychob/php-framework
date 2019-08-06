<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility\StringManipulation;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\TypeAssert;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    trait StrFindTrait
    {
        /**
         * This function finds first character that is not one of $toFind
         *
         * @param string          $input  Input string
         * @param string|string[] $toFind Characters to find, either as string (then individual character will be
         *                                checked), or as array (then elements from array will be checked)
         * @param int             $offset From which index you want to start searching. Negative index means relative
         *                                to end.
         *
         * @return int|bool
         */
        public static function findFirstNotOf(string $input, $toFind, int $offset = 0)
        {
            $offset = self::findFirst_ensureArguments($input, $toFind, $offset);

            if (Arr::is($toFind)) {
                return self::findFirstNot_Array($input, $toFind, $offset);
            } else {
                return self::findFirstNot_Str($input, $toFind, $offset);
            }
        }

        /**
         * @param string   $input
         * @param string[] $chrs
         * @param int      $offset
         *
         * @return int|bool
         */
        private static function findFirstNot_Array(string $input, array $chrs, int $offset)
        {
            for ($it = $offset, $len = Str::len($input); $it < $len; ++$it) {
                if (!Arr::contains($chrs, $input[$it])) {
                    return $it;
                }
            }

            return false;
        }

        /**
         * @param string $input
         * @param string $characters
         * @param int    $offset
         *
         * @return int|bool
         */
        private static function findFirstNot_Str(string $input, string $characters, int $offset)
        {
            for ($it = $offset, $inLen = Str::len($input), $chrLen = Str::len($characters); $it < $inLen; ++$it) {
                for ($jt = 0; $jt < $chrLen; ++$jt) {
                    if ($input[$it] === $characters[$jt]) {
                        continue 2;
                    }
                }

                return $it;
            }

            return false;
        }

        public static function findFirstOf(string $input, $toFind, int $offset = 0)
        {
            $offset = self::findFirst_ensureArguments($input, $toFind, $offset);

            if (Arr::is($toFind)) {
                return self::findFirst_Array($input, $toFind, $offset);
            } else {
                return self::findFirst_Str($input, $toFind, $offset);
            }
        }

        /**
         * @param string   $input
         * @param string[] $chrs
         * @param int      $offset
         *
         * @return int|bool
         */
        private static function findFirst_Array(string $input, array $chrs, int $offset)
        {
            for ($it = $offset, $len = Str::len($input); $it < $len; ++$it) {
                if (Arr::contains($chrs, $input[$it])) {
                    return $it;
                }
            }

            return false;
        }

        /**
         * @param string $input
         * @param string $characters
         * @param int    $offset
         *
         * @return int|bool
         */
        private static function findFirst_Str(string $input, string $characters, int $offset)
        {
            for ($it = $offset, $inLen = Str::len($input), $chrLen = Str::len($characters); $it < $inLen; ++$it) {
                for ($jt = 0; $jt < $chrLen; ++$jt) {
                    if ($input[$it] === $characters[$jt]) {
                        return $it;
                    }
                }
            }

            return false;
        }

        /**
         * @param string $input
         * @param        $toFind
         * @param int    $offset
         *
         * @return int
         */
        private static function findFirst_ensureArguments(string $input, $toFind, int $offset): int
        {
            Assert::arguments('find must be array or string', 'toFind', 2)
                  ->hasType($toFind, [
                      TypeAssert::TYPE_STRING,
                      TypeAssert::TYPE_ARRAY,
                  ]);

            $inLen = Str::len($input);

            Assert::arguments('offset must be smaller then input string length', 'offset', 3)
                  ->isSmallerOrEqual($offset, $inLen);

            if ($offset < 0) {
                Assert::arguments('relative offset must be smaller then input string length', 'offset', 3)
                      ->isGreaterOrEqual($offset, -$inLen);
            }

            if ($offset < 0) {
                $offset += $inLen;
            }

            return $offset;
        }
    }
