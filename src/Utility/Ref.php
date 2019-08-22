<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    use Jawira\CaseConverter\Convert;
    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeAssert;

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

        public static function getEnumValues($obj, string $startsWith = ''): array
        {
            Assert::arguments('must be object or string', 'obj', 1)
                  ->typeIs($obj, [
                      TypeAssert::TYPE_OBJECT,
                      TypeAssert::TYPE_STRING,
                  ]);

            $ref = new \ReflectionClass($obj);
            $ret = [];

            foreach ($ref->getConstants() as $name => $value) {
                if (empty($startsWith) || Str::startsWith($name, $startsWith)) {
                    $ret[$name] = $value;
                }
            }

            return $ret;
        }
    }
