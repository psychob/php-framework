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
        public const MERGE_USE_LATEST = 0b00000001;
        public const MERGE_PRESERVE_KEYS = 0b00000010;

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

        public static function sortByKey(array &$container)
        {
            ksort($container);
        }

        public static function get($container, $key, $default = NULL)
        {
            if (Arr::has($container, $key)) {
                return $container[$key];
            }

            return $default;
        }

        public static function recursiveGet($container, array $elements, $default = NULL)
        {
            foreach ($elements as $idx) {
                if (Arr::has($container, $idx)) {
                    $container = $container[$idx];
                } else {
                    return $default;
                }
            }

            return $container;
        }

        public static function merge(int $type, array ...$arrays): array
        {
            switch ($type) {
                case self::MERGE_USE_LATEST:
                    return static::mergePickLatest(...$arrays);
            }
        }

        private static function mergePickLatest(...$arrays)
        {
            return array_merge_recursive(...$arrays);
        }

        public static function keys(array $arr): array
        {
            return array_keys($arr);
        }
    }
