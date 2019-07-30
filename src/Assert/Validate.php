<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    use PsychoB\Framework\Assert\Exception\AssertionException;

    /**
     * Class Validate
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @method static isTrue($obj): void
     * @method static isFalse($obj): void
     * @method static isEqual(mixed $left, mixed $right): void
     */
    final class Validate
    {
        public static function __callStatic($name, $arguments)
        {
            try {
                Assert::__callStatic($name, $arguments);
            } catch (AssertionException $e) {
                return false;
            }

            return true;
        }
    }
