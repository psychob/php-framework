<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    class Str
    {
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
                return 'array';
            }

            if (is_object($element)) {
                return sprintf('%s', get_class($element));
            }

            return '???';
        }
    }
