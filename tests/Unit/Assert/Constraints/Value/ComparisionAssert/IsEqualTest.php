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
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ValuesAreDifferentException
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ComparisionAssertException
     */
    class IsEqualTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsEqual($left, $right): void
        {
            ComparisionAssert::isEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsEqualFailure($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);

            ComparisionAssert::isEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsEqualFailureWithMessage($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            ComparisionAssert::isEqual($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsEqualThroughAssert($left, $right): void
        {
            Assert::isEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsEqualFailureThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);

            Assert::isEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsEqualFailureWithMessageThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            Assert::isEqual($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideEqualValues() */
        public function testIsEqualThroughValidate($left, $right): void
        {
            $this->assertTrue(Validate::isEqual($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsEqualFailureThroughValidate($left, $right): void
        {
            $this->assertFalse(Validate::isEqual($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotEqualValues() */
        public function testIsEqualException($left, $right): void
        {
            $catched = false;

            try {
                ComparisionAssert::isEqual($left, $right);
            } catch (ValuesAreDifferentException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertFalse($e->isStrict());
            }

            $this->assertTrue($catched);
        }
    }
