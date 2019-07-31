<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Assert\Exception\TypeDoesntMatchException;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class TypeAssert
    {
        public const TYPE_STRING = '*string';
        public const TYPE_ARRAY  = '*array';

        public static function ensure($obj, $type, ?string $message = NULL): void
        {
            if (Str::is($type)) {
                if (!static::matchStringType($obj, $type)) {
                    throw new TypeDoesntMatchException($obj, $type, $message);
                }
            } else if (Arr::is($type)) {
                if (Arr::hasMultiple($type, 'type', 'class') && Arr::len($type) === 2) {
                    if (!static::matchOneArray($obj, $type)) {
                        throw new TypeDoesntMatchException($obj, $type, $message);
                    }
                } else {
                    foreach ($type as $element) {
                        if (Str::is($element)) {
                            if (static::matchStringType($obj, $element)) {
                                return;
                            }
                        } else if (Arr::hasMultiple($element, 'type', 'class') && Arr::len($type) === 2) {
                            if (static::matchOneArray($obj, $element)) {
                                return;
                            }
                        } else {
                            throw new TypeDoesntMatchException($obj, $type, $message);
                        }
                    }

                    throw new TypeDoesntMatchException($obj, $type, $message);
                }
            } else {
                throw new TypeDoesntMatchException($obj, $type, $message);
            }
        }

        public static function exactType(string $class): string
        {
            return $class;
        }

        public static function implements(string $implements): array
        {
            return ['type' => 'implements', 'class' => $implements];
        }

        private static function matchStringType($obj, string $type): bool
        {
            if (Str::startsWith($type, '*')) {
                return gettype($obj) === Str::substr($type, 1);
            }

            return get_class($obj) === $type;
        }

        private static function matchOneArray($obj, array $type): bool
        {
            switch ($type['type']) {
                case 'implements':
                    return $obj instanceof $type['class'];
            }
        }
    }
