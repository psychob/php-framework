<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint\ObjectProperties;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\ObjectProperties\IsNotEmptyAssert;
    use PsychoB\Framework\Assert\Constraints\ObjectProperties\ValueIsEmptyException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class IsNotEmptyAssertTest extends UnitTestCase
    {
        public function provideTrueTestData(): array
        {
            return [
                [['a']],
            ];
        }

        public function provideFalseTestData(): array
        {
            return [
                [[]],
            ];
        }

        /** @dataProvider provideTrueTestData */
        public function testTrue($value): void
        {
            IsNotEmptyAssert::ensure($value);
            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalse($value): void
        {
            $this->expectException(ValueIsEmptyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));
            IsNotEmptyAssert::ensure($value);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWithCustomMessage($value): void
        {
            $this->expectException(ValueIsEmptyException::class);
            $this->expectExceptionMessage('Custom Message');

            IsNotEmptyAssert::ensure($value, "Custom Message");
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughAssert($value): void
        {
            Assert::isNotEmpty($value);

            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughAssert($value): void
        {
            $this->expectException(ValueIsEmptyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));

            Assert::isNotEmpty($value);
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughValidate($value): void
        {
            $this->assertTrue(Validate::isNotEmpty($value));
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughValidate($value): void
        {
            $this->assertFalse(Validate::isNotEmpty($value));
        }
    }
