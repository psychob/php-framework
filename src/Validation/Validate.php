<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation;

    /**
     * Class Validate
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @method static isEqual($left, $right): bool
     * @method static isTrue($obj): bool
     * @method static propIsEqual($obj, string $property, $value): bool
     * @method static propRequirement($obj, string $properties): bool
     */
    class Validate
    {
        use AssertDatabaseTrait;

        public static function __callStatic($name, $arguments)
        {
            return call_user_func_array([static::get($name), 'validate'], $arguments);
        }
    }
