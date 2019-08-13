<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint\TypeProperties;

    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeDoesntMatchException;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeIsAssert;
    use PsychoB\Framework\Exception\InvalidArgumentException;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\NoConstructorMock;
    use Throwable;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\TypeProperties\TypeIsAssert
     * @covers \PsychoB\Framework\Assert\Constraints\TypeProperties\TypeDoesntMatchException
     */
    class TypeIsAssertTest extends UnitTestCase
    {
        public function provideTrueTestData(): array
        {
            return [
                [1, TypeIsAssert::TYPE_INT],
                [1.0, TypeIsAssert::TYPE_FLOAT],
                ["str", TypeIsAssert::TYPE_STRING],
                [["str"], TypeIsAssert::TYPE_ARRAY],
                [[], TypeIsAssert::TYPE_ARRAY],

                [1, [TypeIsAssert::TYPE_INT]],
                [false, [TypeIsAssert::TYPE_INT, TypeIsAssert::TYPE_BOOLEAN]],

                [$this, [TypeIsAssert::TYPE_STRING, TypeIsAssert::implements(UnitTestCase::class)]],
                [$this, TypeIsAssert::implements(UnitTestCase::class)],
            ];
        }

        public function provideFalseTestData(): array
        {
            return [
                [1, TypeIsAssert::TYPE_STRING],
                [1.0, [TypeIsAssert::TYPE_INT, TypeIsAssert::TYPE_ARRAY]],
                ["string", TypeIsAssert::implements(Throwable::class)],
            ];
        }

        /** @dataProvider provideTrueTestData */
        public function testTrue($obj, $type): void
        {
            TypeIsAssert::ensure($obj, $type);
            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalse($obj, $type): void
        {
            $this->expectException(TypeDoesntMatchException::class);
            TypeIsAssert::ensure($obj, $type);
        }

        public function testInvalidArgument_Scalar(): void
        {
            $this->expectException(InvalidArgumentException::class);

            TypeIsAssert::ensure(1, 1);
        }

        public function testInvalidArgument_Array(): void
        {
            $this->expectException(InvalidArgumentException::class);

            TypeIsAssert::ensure(1, [1]);
        }

        public function testInvalidArgument_ArrayInvalidType(): void
        {
            $this->expectException(InvalidArgumentException::class);

            $arg = TypeIsAssert::implements(static::class);
            $arg['type'] = 'foo';

            TypeIsAssert::ensure(1, $arg);
        }

        public function testExactType(): void
        {
            TypeIsAssert::ensure($this, TypeIsAssert::exactType(TypeIsAssertTest::class));
            $this->assertTrue(true);
        }

        public function testExceptionMessage(): void
        {
            $this->expectException(TypeDoesntMatchException::class);
            $this->expectExceptionMessage('scalar array or scalar double or implements');

            TypeIsAssert::ensure($this, [
                TypeIsAssert::exactType(TypeIsAssert::TYPE_ARRAY),
                TypeIsAssert::TYPE_FLOAT,
                TypeIsAssert::implements(NoConstructorMock::class),
            ]);
        }
    }
