<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    /**
     * Class Assert
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @method static isTrue($obj, ?string $message = NULL)
     * @method static isFalse($obj, ?string $message = NULL)
     * @method static isEqual(mixed $left, mixed $right, ?string $message = NULL)
     * @method static typeRequirements(mixed $obj, array|string $type, mixed[] $properties, ?string $message = NULL)
     * @method static hasType($obj, mixed|string $type, ?string $message = NULL)
     * @method static isNotEmpty($obj, ?string $message = NULL)
     * @method static unreachable(?string $message = NULL)
     */
    final class Assert extends AssertDatabase
    {
        public static function __callStatic($name, $arguments)
        {
            return call_user_func_array([static::get($name), 'ensure'], $arguments);
        }

        public static function arguments(?string $message = NULL, ?string $name = NULL, ?int $position = NULL)
        {
            return new AssertArgument($name, $position, $message);
        }
    }
