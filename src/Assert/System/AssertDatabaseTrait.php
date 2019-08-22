<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\System;

    use PsychoB\Framework\Assert\Exception\AssertNotFoundException;
    use PsychoB\Framework\Utility\Arr;

    abstract class AssertDatabaseTrait
    {
        protected static $asserts = [
            //
        ];

        public static function __callStatic(string $name, $arguments)
        {
            if (Arr::has(static::$asserts, $name)) {
                $callable = static::$asserts[$name];

                return call_user_func_array($callable, $arguments);
            }

            if (GenericAssertDatabase::has($name)) {
                return GenericAssertDatabase::__callStatic($name, $arguments);
            }

            throw new AssertNotFoundException($name,
                Arr::merge(Arr::MERGE_VALUES | Arr::MERGE_MAKE_UNIQUE, Arr::keys(static::$asserts), Arr::keys(GenericAssertDatabase::$asserts)));
        }

        public static function has(string $name): bool
        {
            return Arr::has(static::$asserts, $name);
        }
    }
