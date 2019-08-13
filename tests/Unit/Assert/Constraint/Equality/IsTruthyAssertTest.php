<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint\Equality;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Equality\IsTruthyAssert;
    use PsychoB\Framework\Assert\Constraints\Equality\ValueIsNotTruthyException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class IsTruthyAssertTest extends UnitTestCase
    {
        public function provideTrueTestData(): array
        {
            return [
                [1],
                [2],
                [true],
                ["1"],
                ["false"],
                ["true"],
            ];
        }

        public function provideFalseTestData(): array
        {
            return [
                [0],
                [false],
                [""],
            ];
        }

        /** @dataProvider provideTrueTestData */
        public function testTrue($value): void
        {
            IsTruthyAssert::ensure($value);
            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalse($value): void
        {
            $this->expectException(ValueIsNotTruthyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));
            IsTruthyAssert::ensure($value);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWithCustomMessage($value): void
        {
            $this->expectException(ValueIsNotTruthyException::class);
            $this->expectExceptionMessage('Custom Message');

            IsTruthyAssert::ensure($value, "Custom Message");
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughAssert($value): void
        {
            Assert::isTruthy($value);

            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughAssert($value): void
        {
            $this->expectException(ValueIsNotTruthyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));

            Assert::isTruthy($value);
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughValidate($value): void
        {
            $this->assertTrue(Validate::isTruthy($value));
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughValidate($value): void
        {
            $this->assertFalse(Validate::isTruthy($value));
        }
    }
