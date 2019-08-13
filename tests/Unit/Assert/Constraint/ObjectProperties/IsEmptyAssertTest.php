<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint\ObjectProperties;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\ObjectProperties\IsEmptyAssert;
    use PsychoB\Framework\Assert\Constraints\ObjectProperties\ValueIsNotEmptyException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class IsEmptyAssertTest extends UnitTestCase
    {
        public function provideTrueTestData(): array
        {
            return [
                [[]],
            ];
        }

        public function provideFalseTestData(): array
        {
            return [
                [['a']],
            ];
        }

        /** @dataProvider provideTrueTestData */
        public function testTrue($value): void
        {
            IsEmptyAssert::ensure($value);
            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalse($value): void
        {
            $this->expectException(ValueIsNotEmptyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));
            IsEmptyAssert::ensure($value);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWithCustomMessage($value): void
        {
            $this->expectException(ValueIsNotEmptyException::class);
            $this->expectExceptionMessage('Custom Message');

            IsEmptyAssert::ensure($value, "Custom Message");
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughAssert($value): void
        {
            Assert::isEmpty($value);

            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughAssert($value): void
        {
            $this->expectException(ValueIsNotEmptyException::class);
            $this->expectExceptionMessage(Str::toRepr($value));

            Assert::isEmpty($value);
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughValidate($value): void
        {
            $this->assertTrue(Validate::isEmpty($value));
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughValidate($value): void
        {
            $this->assertFalse(Validate::isEmpty($value));
        }
    }
