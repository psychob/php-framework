<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    use Jawira\CaseConverter\Convert;

    class Ref
    {
        public static function havePublicMethod(object $object, string $method): bool
        {
            $ref = new \ReflectionClass($object);
            if ($ref->hasMethod($method)) {
                $prop = $ref->getMethod($method);

                return $prop->isPublic();
            }

            return false;
        }

        public static function havePublicProperty(object $object, string $property): bool
        {
            $ref = new \ReflectionClass($object);
            if ($ref->hasProperty($property)) {
                $prop = $ref->getProperty($property);

                return $prop->isPublic();
            }

            return false;
        }

        public static function haveAccessorTo(object $object, string $property): bool
        {
            $ref = new \ReflectionClass($object);

            $converter = new Convert('get ' . $property);
            $propertyName = $converter->toCamel();

            return Ref::havePublicMethod($object, $propertyName);
        }

        public static function getAccessorTo(object $object, string $property): callable
        {
            $ref = new \ReflectionClass($object);

            $converter = new Convert('get ' . $property);
            $method = $converter->toCamel();

            if ($ref->hasMethod($method)) {
                $prop = $ref->getMethod($method);

                return function () use ($object, $prop) {
                    return $prop->invoke($object);
                };
            }
        }

        public static function implements($obj, string $interface): bool
        {
            $ref = new \ReflectionClass($obj);

            return Arr::contains($ref->getInterfaceNames(), $interface);
        }
    }
