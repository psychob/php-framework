<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    use PsychoB\Framework\Assert\Constraints\ClassImplementsAssert;
    use PsychoB\Framework\Assert\Constraints\Equality\IsFalsyAssert;
    use PsychoB\Framework\Assert\Constraints\Equality\IsTruthyAssert;
    use PsychoB\Framework\Assert\Constraints\HasNoKeyAssert;
    use PsychoB\Framework\Assert\Constraints\IsEqualAssert;
    use PsychoB\Framework\Assert\Constraints\Identity\IsFalseAssert;
    use PsychoB\Framework\Assert\Constraints\IsGreaterOrEqualAssert;
    use PsychoB\Framework\Assert\Constraints\ObjectProperties\IsEmptyAssert;
    use PsychoB\Framework\Assert\Constraints\ObjectProperties\IsNotEmptyAssert;
    use PsychoB\Framework\Assert\Constraints\IsSmallerOrEqualAssert;
    use PsychoB\Framework\Assert\Constraints\Identity\IsTrueAssert;
    use PsychoB\Framework\Assert\Constraints\ObjectPropertiesAssert;
    use PsychoB\Framework\Assert\Constraints\PropertyIsEqualAssert;
    use PsychoB\Framework\Assert\Constraints\TypeAssert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeHasAssert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeIsAssert;
    use PsychoB\Framework\Assert\Constraints\TypeRequirementAssert;
    use PsychoB\Framework\Assert\Constraints\UnreachableAssert;
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
            'isEqual' => IsEqualAssert::class,
            'isPropertyEqual' => PropertyIsEqualAssert::class,
            'hasProperties' => ObjectPropertiesAssert::class,
            'unreachable' => UnreachableAssert::class,
            'isSmallerOrEqual' => IsSmallerOrEqualAssert::class,
            'isGreaterOrEqual' => IsGreaterOrEqualAssert::class,
            'hasNoKey' => HasNoKeyAssert::class,
            'classImplements' => ClassImplementsAssert::class,

            // equality
            'isTruthy' => IsTruthyAssert::class,
            'isFalsy' => IsFalsyAssert::class,

            // identity
            'isTrue' => IsTrueAssert::class,
            'isFalse' => IsFalseAssert::class,

            // object properties
            'isEmpty' => IsEmptyAssert::class,
            'isNotEmpty' => IsNotEmptyAssert::class,

            // type properties
            'typeHas' => TypeHasAssert::class,
            'typeIs' => TypeIsAssert::class,
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
