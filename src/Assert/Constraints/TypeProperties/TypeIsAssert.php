<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\TypeProperties;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class TypeIsAssert
    {
        const TYPE_INT     = '*integer';
        const TYPE_STRING  = '*string';
        const TYPE_ARRAY   = '*array';
        const TYPE_FLOAT   = '*double';
        const TYPE_BOOLEAN = '*boolean';

        public static function ensure($obj, $type, ?string $message = NULL): void
        {
            if (Str::is($type)) {
                if (static::matchStringType($obj, $type)) {
                    return;
                }
            } else if (Arr::is($type)) {
                if (Arr::hasMultiple($type, 'type', 'class') && Arr::len($type) === 2) {
                    if (static::matchOneArray($obj, $type)) {
                        return;
                    }
                } else {
                    foreach ($type as $element) {
                        if (Str::is($element)) {
                            if (static::matchStringType($obj, $element)) {
                                return;
                            }
                        } else if (Arr::is($element) &&
                            Arr::hasMultiple($element, 'type', 'class') &&
                            Arr::len($element) === 2) {
                            if (static::matchOneArray($obj, $element)) {
                                return;
                            }
                        } else {
                            Assert::arguments('Type must be either array or string', 'type', 2)
                                  ->unreachable();
                        }
                    }
                }
            } else {
                Assert::arguments('Type must be either array or string', 'type', 2)
                      ->unreachable();
            }

            throw new TypeDoesntMatchException($obj, $type, $message);
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

                default:
                    Assert::arguments('Type must be either array or string', 'type', 2)
                          ->unreachable();
            }
        } // @codeCoverageIgnore
    }
