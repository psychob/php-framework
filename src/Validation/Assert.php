<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation;

    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Validation\Asserts\Exception\AssertionNotFoundException;
    use PsychoB\Framework\Validation\Asserts\PropertyIsEqual;
    use PsychoB\Framework\Validation\Asserts\IsEqual;
    use PsychoB\Framework\Validation\Asserts\IsTrue;

    /**
     * Class Assert
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @method static isEqual($left, $right, string $message = '')
     * @method static isTrue($expr, string $message = '')
     * @method static isFalse($expr, string $message = '')
     * @method static typeRequirements(object $obj, string $class, mixed[] $properties, string $message = '')
     * @method static exactType(object $obj, string $class, string $message = '')
     * @method static hasProps(object $obj, mixed[] $properties, string $message = '')
     */
    class Assert
    {
        protected static $AssertImpl = [
            'isEqual' => IsEqual::class,
            'isTrue' => IsTrue::class,
            'isFalse' => IsFalse::class,
            'typeRequirements' => TypeRequirements::class,
            'exactType' => ExactType::class,
            'hasProps' => HasProps::class,
            'propEqual' => PropertyIsEqual::class,
        ];

        public static function __callStatic($name, $arguments)
        {
            if (Arr::has(self::$AssertImpl, $name)) {
                call_user_func_array([self::$AssertImpl[$name], 'ensure'], $arguments);
            } else {
                throw new AssertionNotFoundException(Arr::keys(self::$AssertImpl), $name);
            }
        }
    }
