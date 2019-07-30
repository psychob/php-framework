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
     * @method static isTrue($obj)
     * @method static isFalse($obj)
     * @method static isEqual(mixed $left, mixed $right)
     * @method static typeRequirements(mixed $obj, array|string $type, mixed[] $properties, ?string $message = NULL)
     * @method static hasType($obj, mixed|string $type, ?string $message = NULL)
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
