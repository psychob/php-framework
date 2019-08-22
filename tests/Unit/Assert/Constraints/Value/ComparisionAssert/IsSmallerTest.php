<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValueIsNotSmallerException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ValueIsNotSmallerException
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ComparisionAssertException
     */
    class IsSmallerTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsSmaller($left, $right)
        {
            ComparisionAssert::isSmaller($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsSmallerFailure($left, $right)
        {
            $this->expectException(ValueIsNotSmallerException::class);

            ComparisionAssert::isSmaller($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsSmallerFailureWithMessage($left, $right)
        {
            $this->expectException(ValueIsNotSmallerException::class);
            $this->expectExceptionMessage('asd89das89dasnuidasnuidas');

            ComparisionAssert::isSmaller($left, $right, 'asd89das89dasnuidasnuidas');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsSmallerException($left, $right)
        {
            $catched = false;

            try {
                ComparisionAssert::isSmaller($left, $right);
            } catch (ValueIsNotSmallerException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertFalse($e->isStrict());
                $this->assertStringContainsString('is not smaller then', $e->getMessage());
            }

            $this->assertTrue($catched);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsSmallerThroughAssert($left, $right)
        {
            Assert::isSmaller($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsSmallerFailureThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotSmallerException::class);

            Assert::isSmaller($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsSmallerFailureWithMessageThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotSmallerException::class);
            $this->expectExceptionMessage('ad90dfs90uvf90idvfojidvf');

            Assert::isSmaller($left, $right, 'ad90dfs90uvf90idvfojidvf');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsSmallerThroughValidate($left, $right)
        {
            $this->assertTrue(Validate::isSmaller($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsSmallerFailureThroughValidate($left, $right)
        {
            $this->assertFalse(Validate::isSmaller($left, $right));
        }
    }
