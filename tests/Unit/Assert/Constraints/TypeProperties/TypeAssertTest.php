<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\TypeProperties;

    use PHPUnit\Framework\TestCase;
    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeAssert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeSpecificationNotSatisfiedException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Exception\InvalidArgumentException;
    use PsychoB\Framework\Testing\UnitTestCase;

    class TypeAssertTest extends UnitTestCase
    {
        public function providerTrueData(): array
        {
            return [
                // basic types,
                [NULL, TypeAssert::TYPE_NULL,],
                [42, TypeAssert::TYPE_INT,],
                [21.37, TypeAssert::TYPE_FLOAT,],
                ['foo', TypeAssert::TYPE_STRING,],
                [true, TypeAssert::TYPE_BOOL,],
                [[], TypeAssert::TYPE_ARRAY,],
                [$this, TypeAssert::TYPE_OBJECT,],
                [[], [TypeAssert::TYPE_ARRAY, TypeAssert::TYPE_OBJECT]],

                // classes
                [$this, static::class],
                [$this, [static::class]],
                [$this, TypeAssert::implements(TestCase::class)],
                [$this, [TypeAssert::implements(TestCase::class)]],
            ];
        }

        public function providerFalseData(): array
        {
            return [
                [NULL, static::class,],
                [NULL, [static::class],],
            ];
        }

        public function providerInvalidInput(): array
        {
            return [
                [NULL, ['type' => '***', 'class' => '']],
                [NULL, [['type' => '***', 'class' => '']]],
                [NULL, [1]],
                [NULL, 1],
            ];
        }

        /** @dataProvider providerTrueData */
        public function testTrueData($value, $type): void
        {
            TypeAssert::typeIs($value, $type);
            $this->assertTrue(true);
        }

        /** @dataProvider providerFalseData */
        public function testFalseData($value, $type): void
        {
            $this->expectException(TypeSpecificationNotSatisfiedException::class);

            TypeAssert::typeIs($value, $type);
        }

        /** @dataProvider providerFalseData */
        public function testFalseDataWithMessage($value, $type): void
        {
            $this->expectException(TypeSpecificationNotSatisfiedException::class);
            $this->expectExceptionMessage('ad9das90das90das90das90');

            TypeAssert::typeIs($value, $type, 'ad9das90das90das90das90');
        }

        /** @dataProvider providerInvalidInput */
        public function testInvalidInputData($value, $type): void
        {
            $this->expectException(InvalidArgumentException::class);

            TypeAssert::typeIs($value, $type);
        }

        public function testImplements(): void
        {
            $this->assertSame([
                'type' => 'implements',
                'class' => static::class,
            ], TypeAssert::implements(static::class));
        }

        public function testThroughAssert(): void
        {
            Assert::typeIs(NULL, TypeAssert::TYPE_NULL);
            $this->assertTrue(true);
        }

        public function testThroughAssertFailure(): void
        {
            $this->expectException(TypeSpecificationNotSatisfiedException::class);
            Assert::typeIs(10, TypeAssert::TYPE_NULL);
        }

        public function testThroughValidate(): void
        {
            $this->assertTrue(Validate::typeIs(null, TypeAssert::TYPE_NULL));
        }

        public function testThroughValidateFailure(): void
        {
            $this->assertFalse(Validate::typeIs(10, TypeAssert::TYPE_NULL));
        }
    }
