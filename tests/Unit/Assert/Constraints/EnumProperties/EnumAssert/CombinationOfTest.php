<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\EnumProperties\EnumAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\EnumProperties\EnumAssert;
    use PsychoB\Framework\Assert\Constraints\EnumProperties\ValueIsNotCombinationEnumException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class CombinationOfTest extends UnitTestCase
    {
        public function provideEnums(): array
        {
            return [
                [1, ['Foo' => 1, 'Bar' => 2]],
                [2, ['Foo' => 1, 'Bar' => 2]],
            ];
        }

        public function provideInvalidEnums(): array
        {
            return [
                [0b1000, ['Foo' => 0b1, 'Bar' => 0b10]],
                [0b1100, ['Foo' => 0b1, 'Bar' => 0b10]],
            ];
        }

        /** @dataProvider provideEnums */
        public function testCombinationOf($value, array $enum)
        {
            EnumAssert::combinationOf($value, $enum);

            $this->assertTrue(true);
        }

        /** @dataProvider provideInvalidEnums */
        public function testCombinationOfFailure($value, array $enum)
        {
            $this->expectException(ValueIsNotCombinationEnumException::class);

            EnumAssert::combinationOf($value, $enum);
        }

        /** @dataProvider provideInvalidEnums */
        public function testCombinationOfFailureWithMessage($value, array $enum)
        {
            $this->expectException(ValueIsNotCombinationEnumException::class);
            $this->expectExceptionMessage('adshuidahuidashuidashui');

            EnumAssert::combinationOf($value, $enum, 'adshuidahuidashuidashui');
        }

        /** @dataProvider provideEnums */
        public function testCombinationOfThroughAssert($value, array $enum)
        {
            Assert::enumCombination($value, $enum);

            $this->assertTrue(true);
        }

        /** @dataProvider provideInvalidEnums */
        public function testCombinationOfFailureThroughAssert($value, array $enum)
        {
            $this->expectException(ValueIsNotCombinationEnumException::class);

            Assert::enumCombination($value, $enum);
        }

        /** @dataProvider provideInvalidEnums */
        public function testCombinationOfFailureWithMessageThroughAssert($value, array $enum)
        {
            $this->expectException(ValueIsNotCombinationEnumException::class);
            $this->expectExceptionMessage('adshuidahuidashuidashui');

            Assert::enumCombination($value, $enum, 'adshuidahuidashuidashui');
        }

        /** @dataProvider provideEnums */
        public function testCombinationOfThroughValidate($value, array $enum)
        {
            $this->assertTrue(Validate::enumCombination($value, $enum));
        }

        /** @dataProvider provideInvalidEnums */
        public function testCombinationOfFailureThroughValidate($value, array $enum)
        {
            $this->assertFalse(Validate::enumCombination($value, $enum));
        }

        /** @dataProvider provideInvalidEnums */
        public function testCombinationOfException($value, array $enum)
        {
            $catched = false;

            try {
                EnumAssert::combinationOf($value, $enum);
            } catch (ValueIsNotCombinationEnumException $e) {
                $catched = true;

                $this->assertSame($value, $e->getValue());
                $this->assertSame($enum, $e->getAvailableValues());
                $this->assertStringContainsString('not one or combination of', $e->getMessage());
            }

            $this->assertTrue($catched);
        }
    }
