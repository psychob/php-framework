<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation;

    /**
     * Class Assert
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @method static isEqual($left, $right, string $message = ''): void
     * @method static isTrue($obj, string $message = ''): void
     * @method static propIsEqual($obj, string $property, $value, string $message = ''): void
     * @method static propRequirement($obj, string $properties, string $message = ''): void
     */
    class Assert
    {
        use AssertDatabaseTrait;

        public static function __callStatic($name, $arguments)
        {
            return call_user_func_array([static::get($name), 'ensure'], $arguments);
        }
    }
