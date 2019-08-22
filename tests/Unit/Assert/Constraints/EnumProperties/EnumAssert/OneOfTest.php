<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\EnumProperties\EnumAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\EnumProperties\EnumAssert;
    use PsychoB\Framework\Assert\Constraints\EnumProperties\ValueIsNotEnumException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class OneOfTest extends UnitTestCase
    {
        public function provideEnums(): array
        {
            return [
                ['foo', ['Foo' => 'foo', 'Bar' => 'bar']],
                ['bar', ['Foo' => 'foo', 'Bar' => 'bar']],
                [1, ['Foo' => 1, 'Bar' => 2]],
                [2, ['Foo' => 1, 'Bar' => 2]],
            ];
        }

        public function provideInvalidEnums(): array
        {
            return [
                ['baz', ['Foo' => 'foo', 'Bar' => 'bar']],
                ['gaz', ['Foo' => 'foo', 'Bar' => 'bar']],
                [3, ['Foo' => 1, 'Bar' => 2]],
                [4, ['Foo' => 1, 'Bar' => 2]],
            ];
        }

        /** @dataProvider provideEnums */
        public function testOneOf($value, array $enum)
        {
            EnumAssert::oneOf($value, $enum);

            $this->assertTrue(true);
        }

        /** @dataProvider provideInvalidEnums */
        public function testOneOfFailure($value, array $enum)
        {
            $this->expectException(ValueIsNotEnumException::class);

            EnumAssert::oneOf($value, $enum);
        }

        /** @dataProvider provideInvalidEnums */
        public function testOneOfFailureWithMessage($value, array $enum)
        {
            $this->expectException(ValueIsNotEnumException::class);
            $this->expectExceptionMessage('adshuidahuidashuidashui');

            EnumAssert::oneOf($value, $enum, 'adshuidahuidashuidashui');
        }

        /** @dataProvider provideEnums */
        public function testOneOfThroughAssert($value, array $enum)
        {
            Assert::enumOne($value, $enum);

            $this->assertTrue(true);
        }

        /** @dataProvider provideInvalidEnums */
        public function testOneOfFailureThroughAssert($value, array $enum)
        {
            $this->expectException(ValueIsNotEnumException::class);

            Assert::enumOne($value, $enum);
        }

        /** @dataProvider provideInvalidEnums */
        public function testOneOfFailureWithMessageThroughAssert($value, array $enum)
        {
            $this->expectException(ValueIsNotEnumException::class);
            $this->expectExceptionMessage('adshuidahuidashuidashui');

            Assert::enumOne($value, $enum, 'adshuidahuidashuidashui');
        }

        /** @dataProvider provideEnums */
        public function testOneOfThroughValidate($value, array $enum)
        {
            $this->assertTrue(Validate::enumOne($value, $enum));
        }

        /** @dataProvider provideInvalidEnums */
        public function testOneOfFailureThroughValidate($value, array $enum)
        {
            $this->assertFalse(Validate::enumOne($value, $enum));
        }

        /** @dataProvider provideInvalidEnums */
        public function testOneOfException($value, array $enum)
        {
            $catched = false;

            try {
                EnumAssert::oneOf($value, $enum);
            } catch (ValueIsNotEnumException $e) {
                $catched = true;

                $this->assertSame($value, $e->getValue());
                $this->assertSame($enum, $e->getAvailableValues());
                $this->assertStringContainsString('not one of', $e->getMessage());
            }

            $this->assertTrue($catched);
        }
    }
