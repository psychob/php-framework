<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    use ArrayAccess;

    class Arr
    {
        public static function has($arr, $index): bool
        {
            if ($arr instanceof ArrayAccess) {
                return $arr->offsetExists($index);
            }

            if (is_array($arr)) {
                return array_key_exists($index, $arr);
            }

            throw InvalidArgumentException::isArray($arr, '$arr', 1);
        }

        public static function hasMultiple($arr, ...$indexes): bool
        {
            foreach ($indexes as $idx) {
                if (!static::has($arr, $idx)) {
                    return false;
                }
            }

            return true;
        }

        public static function contains($array, $element): bool
        {
            return in_array($element, $array);
        }

        public static function push(array &$array, $element): void
        {
            array_push($array, $element);
        }

        public static function pop(array &$array)
        {
            return array_pop($array);
        }
    }
