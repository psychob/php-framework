<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    class Str
    {
        const COMPARE_LENGTH_REVERSE = [Str::class, 'cmpLengthReverse'];

        use StringManipulation\StrInfoTrait;

        /**
         * Convert $element to string, while also preserving some information about type
         *
         * @param mixed $element
         *
         * @return string
         */
        public static function toRepr($element): string
        {
            if ($element === NULL) {
                return "null";
            }

            if (is_scalar($element)) {
                if ($element === true || $element === false) {
                    return 'bool(' . ($element ? 'true' : 'false') . ')';
                } else {
                    return sprintf('%s(%s)', gettype($element), strval($element));
                }
            }

            if (is_array($element)) {
                $ret = '';

                foreach ($element as $value) {
                    $ret .= self::toRepr($value) . ', ';
                }

                return '[' . $ret . ']';
            }

            if (is_object($element)) {
                return sprintf('%s', get_class($element));
            }

            return '???';
        }

        /**
         * Match regular expression and return matched groups if any. FALSE if nothing was matched.
         *
         * @param string $regExp
         * @param string $subject
         *
         * @return mixed[]|false
         */
        public static function matchGroups(string $regExp, string $subject)
        {
            $matches = [];

            if (preg_match($regExp, $subject, $matches) === 1) {
                $ret = [];

                foreach ($matches as $id => $match) {
                    if ($id === 0) {
                        continue;
                    }

                    $ret[] = $match;
                }

                return $ret;
            }

            return false;
        }

        public static function toType($obj): string
        {
            if ($obj === NULL) {
                return "null";
            }

            if (is_scalar($obj)) {
                return gettype($obj);
            }

            if (is_array($obj)) {
                return 'array';
            }

            return get_class($obj);
        }

        public static function escapeHtml(string $html): string
        {
            return htmlspecialchars($html);
        }

        public static function toStr($arg): string
        {
            if ($arg === NULL) {
                return "null";
            }

            if (is_scalar($arg)) {
                return strval($arg);
            }

            return "???";
        }

        public static function explode(string $string, string $separator): array
        {
            return explode($separator, $string);
        }

        public static function startsWith(string $string, string $substring): bool
        {
            return strpos($string, $substring) === 0;
        }

        public static function remove(string $string, string $toRemove): string
        {
            return Str::replace($string, $toRemove, '');
        }

        public static function replace(string $string, string $toReplace, string $replaceWith): string
        {
            return str_replace($toReplace, $replaceWith, $string);
        }

        public static function upperCaseWords(string $string, string $delimiters = " \t\r\n\f\v"): string
        {
            return ucwords($string, $delimiters);
        }

        public static function toLower(string $string): string
        {
            return strtolower($string);
        }

        public static function equals(string $left, string $right, ?int $length = NULL): bool
        {
            if ($length === NULL) {
                return $left === $right;
            } else {
                return strncmp($left, $right, $length) === 0;
            }
        }

        public static function cmpLengthReverse(string $left, string $right): int
        {
            return -(Str::len($left) <=> Str::len($right));
        }

        public static function equalsPart(string $left,
            int $leftStart,
            int $leftLength,
            string $right,
            int $rightStart,
            int $rightLength): bool
        {
            $left_sub = substr($left, $leftStart, $leftLength);
            $right_sub = substr($right, $rightStart, $rightLength);

            return $left_sub === $right_sub;
        }

        public static function contains(string $str, string $toFind): bool
        {
            return Str::findFirst($str, $toFind) !== false;
        }

        public static function findFirst(string $str, string $toFind, int $offset = 0)
        {
            return strpos($str, $toFind, $offset);
        }

        public static function substr(string $str, int $start, ?int $len = NULL): string
        {
            if ($len === NULL) {
                return substr($str, $start);
            }

            return substr($str, $start, $len);
        }

        public static function endsWith(string $string, string $end): bool
        {
            $substr = substr($string, -strlen($end));

            return $substr === $end;
        }
        public static function toUpper(string $str): string
        {
            return strtoupper($str);
        }
    }
