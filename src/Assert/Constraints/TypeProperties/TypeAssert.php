<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\TypeProperties;

    use PsychoB\Framework\Exception\InvalidArgumentException;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class TypeAssert
    {
        public const TYPE_STRING = '*string';
        public const TYPE_ARRAY  = '*array';
        public const TYPE_NULL   = '*null';
        public const TYPE_INT    = '*integer';
        public const TYPE_FLOAT  = '*double';
        public const TYPE_BOOL   = '*boolean';
        public const TYPE_OBJECT = '*object';

        /**
         * @param mixed                   $value
         * @param string|string[]|mixed[] $type
         * @param string|null             $message
         */
        public static function typeIs($value, $type, ?string $message = NULL): void
        {
            if (Str::is($type)) {
                if (static::typeIsString($value, $type)) {
                    return;
                }
            } else if (Arr::is($type)) {
                if (Arr::len($type) === 2 && Arr::hasMultiple($type, 'type', 'class')) {
                    if (static::typeIsArray($value, $type)) {
                        return;
                    }
                } else {
                    foreach ($type as $t) {
                        if (Str::is($t)) {
                            if (static::typeIsString($value, $t)) {
                                return;
                            }
                        } else if (Arr::is($t) && Arr::len($t) === 2 && Arr::hasMultiple($t, 'type', 'class')) {
                            if (static::typeIsArray($value, $t)) {
                                return;
                            }
                        } else {
                            throw new InvalidArgumentException('type', 2,
                                sprintf('Invalid type of type definition: %s', Str::toRepr($t)));
                        }
                    }
                }
            } else {
                throw new InvalidArgumentException('type', 2,
                    sprintf('Invalid type of type definition: %s', Str::toRepr($type)));
            }

            throw new TypeSpecificationNotSatisfiedException($value, $type, $message);
        }

        private static function typeIsString($value, string $type): bool
        {
            if (Str::startsWith($type, '*')) {
                if ($type === self::TYPE_NULL) {
                    return is_null($value);
                }

                return gettype($value) === Str::substr($type, 1);
            }

            if (gettype($value) === 'object') {
                return get_class($value) === $type;
            }

            return false;
        }

        private static function typeIsArray($value, array $type): bool
        {
            switch ($type['type']) {
                case 'implements':
                    return $value instanceof $type['class'];

                default:
                    throw new InvalidArgumentException('type', 2, 'Invalid type in complex type specification');
            }
        }

        public static function implements(string $base): array
        {
            return ['type' => 'implements', 'class' => $base];
        }
    }
