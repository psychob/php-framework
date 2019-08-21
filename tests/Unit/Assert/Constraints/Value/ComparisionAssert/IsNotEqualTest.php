<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValuesAreDifferentException;
    use PsychoB\Framework\Assert\Constraints\Value\ValuesAreSameException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class IsNotEqualTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsNotEqual($left, $right): void
        {
            ComparisionAssert::isNotEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsNotEqualFailure($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);

            ComparisionAssert::isNotEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsNotEqualFailureWithMessage($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            ComparisionAssert::isNotEqual($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsNotEqualThroughAssert($left, $right): void
        {
            Assert::notEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsNotEqualFailureThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);

            Assert::notEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsNotEqualFailureWithMessageThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            Assert::notEqual($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsNotEqualThroughValidate($left, $right): void
        {
            $this->assertTrue(Validate::notEqual($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsNotEqualFailureThroughValidate($left, $right): void
        {
            $this->assertFalse(Validate::notEqual($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsNotEqualException($left, $right): void
        {
            $catched = false;

            try {
                ComparisionAssert::isNotEqual($left, $right);
            } catch (ValuesAreSameException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertFalse($e->isStrict());
            }

            $this->assertTrue($catched);
        }
    }
