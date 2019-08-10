<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    use Jawira\CaseConverter\Convert;
    use ReflectionClass;

    class Ref
    {
        public static function havePublicMethod(object $object, string $method): bool
        {
            $ref = new ReflectionClass($object);
            if ($ref->hasMethod($method)) {
                $prop = $ref->getMethod($method);

                return $prop->isPublic();
            }

            return false;
        }

        public static function havePublicProperty(object $object, string $property): bool
        {
            $ref = new ReflectionClass($object);
            if ($ref->hasProperty($property)) {
                $prop = $ref->getProperty($property);

                return $prop->isPublic();
            }

            return false;
        }

        public static function haveAccessorTo(object $object, string $property): bool
        {
            $ref = new ReflectionClass($object);

            $converter = new Convert('get ' . $property);
            $propertyName = $converter->toCamel();

            return Ref::havePublicMethod($object, $propertyName);
        }

        public static function getAccessorTo(object $object, string $property): callable
        {
            $ref = new ReflectionClass($object);

            $converter = new Convert('get ' . $property);
            $method = $converter->toCamel();

            if ($ref->hasMethod($method)) {
                $prop = $ref->getMethod($method);

                return function () use ($object, $prop) {
                    return $prop->invoke($object);
                };
            }
        }

        public static function hasTrait($obj, string $class, bool $recursive = false): bool
        {
            if ($recursive) {
                return Arr::exists(self::lazyRecursiveTraitNames($obj), function (string $name) use ($class) {
                    return $class === $name;
                });
            } else {
                $ref = new ReflectionClass($obj);

                return Arr::exists($ref->getTraitNames(), function (string $name) use ($class) {
                    return $class === $name;
                });
            }
        }

        public static function implements($obj, string $interface): bool
        {
            $ref = new ReflectionClass($obj);

            return Arr::contains($ref->getInterfaceNames(), $interface);
        }

        public static function lazyRecursiveTraitNames($class): iterable
        {
            foreach (Ref::lazyRecursiveTraits($class) as $trait) {
                yield $trait->getName();
            }
        }

        /**
         * @param string $class
         *
         * @return ReflectionClass[]
         */
        public static function lazyRecursiveTraits($class): iterable
        {
            /** @var ReflectionClass $class */
            foreach (Ref::lazyRecursiveRelations($class) as $refClass) {
                if ($refClass->isTrait()) {
                    yield $refClass;
                }
            }
        }

        public static function lazyRecursiveRelations($class): iterable
        {
            // we want to recursive check for every relation (interface, trait, parent class)
            // and return it
            $visited = [];
            $toVisit = [$class];

            while (!empty($toVisit)) {
                $class = Arr::pop($toVisit);
                Arr::push($visited, $class);

                $refClass = new ReflectionClass($class);

                foreach ($refClass->getInterfaces() as $interface) {
                    if (!Arr::contains($visited, $interface->getName())) {
                        if (!Arr::contains($toVisit, $interface->getName())) {
                            Arr::push($toVisit, $interface->getName());
                        }
                        yield $interface;
                    }
                }

                foreach ($refClass->getTraits() as $trait) {
                    if (!Arr::contains($visited, $trait->getName())) {
                        if (!Arr::contains($toVisit, $trait->getName())) {
                            Arr::push($toVisit, $trait->getName());
                        }
                        yield $trait;
                    }
                }

                $parent = $refClass->getParentClass();
                if ($parent !== false) {
                    if (!Arr::contains($visited, $parent->getName())) {
                        if (!Arr::contains($toVisit, $parent->getName())) {
                            Arr::push($toVisit, $parent->getName());
                        }
                        yield $parent;
                    }
                }
            }
        }
    }
