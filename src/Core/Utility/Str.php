<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Core\Utility;

    use PsychoB\Framework\Core\Exceptions\UnreachableException;

    class Str
    {
        public static function toStr($object, string $default = ""): string
        {
            if (is_string($object)) {
                return $default;
            } else if (method_exists($object, '__toString')) {
                return $object->__toString();
            } else if (is_scalar($object)) {
                return strval($object);
            }

            return $default;
        }

        public static function toRepr($key): string
        {
            if (is_integer($key)) {
                return strval($key);
            } else if (is_string($key)) {
                return strval($key);
            } else if (is_object($key)) {
                return get_class($key);
            }

            return '???';
        }

        public static function findFirstNot(string $str, $characters): int
        {
            if (is_array($characters)) {
                return static::findFirstNot_Array($str, $characters);
            } else {
                return static::findFirstNot_String($str, $characters);
            }
        }

        private static function findFirstNot_String(string $str, string $chars)
        {
            /// TODO: Use mb_ ?
            $strLen = strlen($str);
            $charsLen = strlen($chars);

            for ($it = 0; $it < $strLen; ++$it) {
                for ($jt = 0; $jt < $charsLen; ++$jt) {
                    if ($str[$it] !== $chars[$jt]) {
                        return $it;
                    }
                }
            }

            return false;
        }

        private static function findFirstNot_Array(string $str, array $chars): int
        {
            $strLen = strlen($str);

            for ($it = 0; $it < $strLen; ++$it) {
                if (!in_array($str[$it], $chars)) {
                    return $it;
                }
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

            if (is_object($obj)) {
                return get_class($obj);
            }

            // @codeCoverageIgnoreStart
            throw new UnreachableException();
            // @codeCoverageIgnoreEnd
        }
    }
