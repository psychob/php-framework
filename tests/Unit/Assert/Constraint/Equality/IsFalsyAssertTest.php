<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint\Equality;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Equality\IsFalsyAssert;
    use PsychoB\Framework\Assert\Constraints\Equality\ValueIsNotFalsyException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class IsFalsyAssertTest extends UnitTestCase
    {
        public function provideFalseTestData(): array
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

        public function provideTrueTestData(): array
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
            IsFalsyAssert::ensure($value);
            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalse($value): void
        {
            $this->expectException(ValueIsNotFalsyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));
            IsFalsyAssert::ensure($value);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWithCustomMessage($value): void
        {
            $this->expectException(ValueIsNotFalsyException::class);
            $this->expectExceptionMessage('Custom Message');

            IsFalsyAssert::ensure($value, "Custom Message");
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughAssert($value): void
        {
            Assert::isFalsy($value);

            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughAssert($value): void
        {
            $this->expectException(ValueIsNotFalsyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));

            Assert::isFalsy($value);
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughValidate($value): void
        {
            $this->assertTrue(Validate::isFalsy($value));
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughValidate($value): void
        {
            $this->assertFalse(Validate::isFalsy($value));
        }
    }
