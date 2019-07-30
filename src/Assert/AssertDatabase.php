<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    use PsychoB\Framework\Assert\Constraints\IsEqualAssert;
    use PsychoB\Framework\Assert\Constraints\IsFalseAssert;
    use PsychoB\Framework\Assert\Constraints\IsTrueAssert;
    use PsychoB\Framework\Assert\Exception\AssertNotFoundException;
    use PsychoB\Framework\Utility\Arr;

    /**
     * Class AssertDatabase
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class AssertDatabase
    {
        /** @var string[] */
        protected static $Assertions = [
            'isTrue' => IsTrueAssert::class,
            'isFalse' => IsFalseAssert::class,
            'isEqual' => IsEqualAssert::class,
        ];

        protected static function add(string $name, string $class): void
        {
            AssertDatabase::$Assertions[$name] = $class;
        }

        protected static function has(string $name): bool
        {
            return Arr::has(AssertDatabase::$Assertions, $name);
        }

        protected static function get(string $name): string
        {
            if (Arr::has(AssertDatabase::$Assertions, $name)) {
                return AssertDatabase::$Assertions[$name];
            }

            throw new AssertNotFoundException($name, AssertDatabase::$Assertions);
        }
    }
