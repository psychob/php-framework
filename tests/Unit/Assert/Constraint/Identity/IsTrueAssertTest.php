<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint\Identity;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Identity\IsTrueAssert;
    use PsychoB\Framework\Assert\Constraints\Identity\ValueIsNotTrueException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class IsTrueAssertTest extends UnitTestCase
    {
        public function provideTrueTestData(): array
        {
            return [
                [true],
            ];
        }

        public function provideFalseTestData(): array
        {
            return [
                [1],
                ["true"],
                ["1"],
                [false],
            ];
        }

        /** @dataProvider provideTrueTestData */
        public function testTrue($value): void
        {
            IsTrueAssert::ensure($value);
            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalse($value): void
        {
            $this->expectException(ValueIsNotTrueException::class);
            $this->expectExceptionMessage(Str::toRepr($value));
            IsTrueAssert::ensure($value);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWithCustomMessage($value): void
        {
            $this->expectException(ValueIsNotTrueException::class);
            $this->expectExceptionMessage('Custom Message');

            IsTrueAssert::ensure($value, "Custom Message");
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughAssert($value): void
        {
            Assert::isTrue($value);

            $this->assertTrue(true);
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughAssert($value): void
        {
            $this->expectException(ValueIsNotTrueException::class);
            $this->expectExceptionMessage(Str::toRepr($value));

            Assert::isTrue($value);
        }

        /** @dataProvider provideTrueTestData */
        public function testTrueWhenCallingThroughValidate($value): void
        {
            $this->assertTrue(Validate::isTrue($value));
        }

        /** @dataProvider provideFalseTestData */
        public function testFalseWhenCallingThroughValidate($value): void
        {
            $this->assertFalse(Validate::isTrue($value));
        }
    }
