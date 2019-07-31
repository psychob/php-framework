<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    use ArrayAccess;
    use phpDocumentor\Reflection\Types\Static_;

    class Arr
    {
        public const MERGE_USE_LATEST    = 0b00000001;
        public const MERGE_PRESERVE_KEYS = 0b00000010;
        public const MERGE_VALUES        = 0b00000100;
        public const MERGE_MAKE_UNIQUE   = 0b00001000;
        public const MERGE_RECURSIVE     = 0b00010000;

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

        public static function recursiveContains($array, array $getter, $element): bool
        {
            return Arr::contains(Arr::recursiveGet($array, $getter, []), $element);
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
                case self::MERGE_USE_LATEST | self::MERGE_RECURSIVE:
                    return static::mergePickLatest(...$arrays);

                case self::MERGE_VALUES | self::MERGE_MAKE_UNIQUE:
                    return static::mergeValuesUnique(...$arrays);
            }
        }

        private static function mergePickLatest(array ...$arrays)
        {
            $keys = [];
            foreach ($arrays as $array) {
                $keys = Arr::merge(Arr::MERGE_VALUES | Arr::MERGE_MAKE_UNIQUE, $keys, Arr::keys($array));
            }

            $ret = [];
            foreach ($keys as $key) {
                $branches = [];
                foreach ($arrays as $array) {
                    if (Arr::has($array, $key)) {
                        $branches[] = Arr::get($array, $key, NULL);
                    }
                }

                // if element last in array is scalar/simple type, we dont need to inspect other values, as they
                // will be discarded
                $lastElement = Arr::last($branches);
                if (!is_array($lastElement)) {
                    $ret[$key] = $lastElement;
                } else {
                    // if it's array, then we can filter our array and remove all non array values, as they will be
                    // discarded
                    $branches = Arr::filter($branches, function ($value) {
                        return is_array($value);
                    });
                    $ret[$key] = Arr::mergePickLatest(...$branches);
                }
            }

            return $ret;
        }

        protected static function mergeValuesUnique(array ...$arrays): array
        {
            return iterator_to_array(Arr::lazyMergeValuesUnique(...$arrays));
        }

        protected static function lazyMergeValuesUnique(array ...$arrays)
        {
            $ret = [];

            foreach ($arrays as $array) {
                foreach ($array as $value) {
                    if (!Arr::contains($ret, $value)) {
                        $ret[] = $value;
                        yield $value;
                    }
                }
            }
        }

        public static function keys(array $arr): array
        {
            return array_keys($arr);
        }

        public static function packArray(...$elements): array
        {
            return $elements;
        }

        public static function first(array $branches)
        {
            reset($branches);

            return current($branches);
        }

        private static function last(array $branches)
        {
            end($branches);

            return current($branches);
        }

        public static function filter(array $arr, $callback): array
        {
            return iterator_to_array(static::lazyFilter($arr, $callback));
        }

        public static function lazyFilter(array $arr, $callback): \Generator
        {
            foreach ($arr as $key => $value) {
                if (call_user_func($callback, $value, $key)) {
                    yield $key => $value;
                }
            }
        }

        public static function pluck($arr, string $key): array
        {
            return iterator_to_array(static::lazyPluck($arr, $key));
        }

        public static function lazyPluck($arr, string $getter): \Generator
        {
            foreach ($arr as $key => $value) {
                if (method_exists($value, $getter)) {
                    yield $key => ($value->$getter());
                } else {
                    yield $key => $value[$getter];
                }
            }
        }

        public static function dropKeys(array $arr): array
        {
            return array_values($arr);
        }

        public static function sortValues(array $arr, $callable): array
        {
            uasort($arr, $callable);

            return $arr;
        }

        public static function toIterator($obj): \Iterator
        {
            if ($obj instanceof \Iterator) {
                return $obj;
            }

            if (is_array($obj)) {
                return new \ArrayIterator($obj);
            }

            return $obj;
        }

        public static function is($obj): bool
        {
            return is_array($obj) || $obj instanceof ArrayAccess;
        }

        public static function len($arr): int
        {
            return count($arr);
        }

        public static function reverse(array $arr)
        {
            return array_reverse($arr);
        }

        public static function appendValues(array $first, array ...$second): array
        {
            return iterator_to_array(static::lazyAppendValues($first, ...$second));
        }

        public static function lazyAppendValues(array $first, array ...$second)
        {
            foreach ($first as $value) {
                yield $value;
            }

            foreach ($second as $arrays) {
                foreach ($arrays as $value) {
                    yield $value;
                }
            }
        }
    }
