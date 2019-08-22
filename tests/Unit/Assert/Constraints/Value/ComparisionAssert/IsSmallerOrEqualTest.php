<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValueIsNotSmallerOrEqualException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ComparisionAssertException
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ValueIsNotSmallerOrEqualException
     */
    class IsSmallerOrEqualTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsSmallerEqual($left, $right)
        {
            ComparisionAssert::isSmallerEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsSmallerEqualFailure($left, $right)
        {
            $this->expectException(ValueIsNotSmallerOrEqualException::class);

            ComparisionAssert::isSmallerEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsSmallerEqualFailureWithMessage($left, $right)
        {
            $this->expectException(ValueIsNotSmallerOrEqualException::class);
            $this->expectExceptionMessage('asd89das89dasnuidasnuidas');

            ComparisionAssert::isSmallerEqual($left, $right, 'asd89das89dasnuidasnuidas');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsSmallerEqualException($left, $right)
        {
            $catched = false;

            try {
                ComparisionAssert::isSmallerEqual($left, $right);
            } catch (ValueIsNotSmallerOrEqualException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertFalse($e->isStrict());
                $this->assertStringContainsString('is not smaller or equal to', $e->getMessage());
            }

            $this->assertTrue($catched);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsSmallerEqualThroughAssert($left, $right)
        {
            Assert::isSmallerOrEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsSmallerEqualFailureThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotSmallerOrEqualException::class);

            Assert::isSmallerOrEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsSmallerEqualFailureWithMessageThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotSmallerOrEqualException::class);
            $this->expectExceptionMessage('ad90dfs90uvf90idvfojidvf');

            Assert::isSmallerOrEqual($left, $right, 'ad90dfs90uvf90idvfojidvf');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsSmallerEqualThroughValidate($left, $right)
        {
            $this->assertTrue(Validate::isSmallerOrEqual($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsSmallerEqualFailureThroughValidate($left, $right)
        {
            $this->assertFalse(Validate::isSmallerOrEqual($left, $right));
        }
    }
