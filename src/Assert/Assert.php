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
     * @method static isTrue($obj, ?string $message = NULL): void
     * @method static isFalse($obj, ?string $message = NULL): void
     */
    final class Assert extends AssertDatabase
    {
        public static function __callStatic($name, $arguments)
        {
            return call_user_func_array([static::get($name), 'ensure'], $arguments);
        }
    }

