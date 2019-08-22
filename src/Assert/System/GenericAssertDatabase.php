<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\System;

    use PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayAssert;
    use PsychoB\Framework\Assert\Constraints\EnumProperties\ValidateEnumAssert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\ClassImplementsAssert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\EmptinessAssert;

    /**
     * Class that contains all default defined asserts
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    final class GenericAssertDatabase extends AssertDatabaseTrait
    {
        protected static $asserts = [
            'enumBits' => [ValidateEnumAssert::class, 'enumBits'],
            'enumArray' => [ValidateEnumAssert::class, 'enumArray'],

            'typeIs' => [TypeAssert::class, 'typeIs'],
            'classImplements' => [ClassImplementsAssert::class, 'classImplements'],

            'isEqual' => [ComparisionAssert::class, 'isEqual'],
            'isSame' => [ComparisionAssert::class, 'isSame'],
            'notEqual' => [ComparisionAssert::class, 'isNotEqual'],
            'notSame' => [ComparisionAssert::class, 'isNotSame'],

            'isEmpty' => [EmptinessAssert::class, 'isEmpty'],
            'notEmpty' => [EmptinessAssert::class, 'isNotEmpty'],

            'isSmaller' => [ComparisionAssert::class, 'isSmaller'],
            'isSmallerOrEqual' => [ComparisionAssert::class, 'isSmallerEqual'],
            'isGreater' => [ComparisionAssert::class, 'isGreater'],
            'isGreaterOrEqual' => [ComparisionAssert::class, 'isGreaterEqual'],

            'hasKey' => [ArrayAssert::class, 'hasKey'],
            'dontHaveKey' => [ArrayAssert::class, 'dontHaveKey'],
        ];
    }
