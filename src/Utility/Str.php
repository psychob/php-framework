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
            if ($obj === null) {
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
    }
