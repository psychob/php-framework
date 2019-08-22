<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValueIsNotGreaterOrEqualException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class IsGreaterOrEqualTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsGreaterEqual($left, $right)
        {
            ComparisionAssert::isGreaterEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsGreaterEqualFailure($left, $right)
        {
            $this->expectException(ValueIsNotGreaterOrEqualException::class);

            ComparisionAssert::isGreaterEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsGreaterEqualFailureWithMessage($left, $right)
        {
            $this->expectException(ValueIsNotGreaterOrEqualException::class);
            $this->expectExceptionMessage('asd89das89dasnuidasnuidas');

            ComparisionAssert::isGreaterEqual($left, $right, 'asd89das89dasnuidasnuidas');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsGreaterEqualException($left, $right)
        {
            $catched = false;

            try {
                ComparisionAssert::isGreaterEqual($left, $right);
            } catch (ValueIsNotGreaterOrEqualException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertFalse($e->isStrict());
                $this->assertStringContainsString('is not greater or equal to', $e->getMessage());
            }

            $this->assertTrue($catched);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsGreaterEqualThroughAssert($left, $right)
        {
            Assert::isGreaterOrEqual($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsGreaterEqualFailureThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotGreaterOrEqualException::class);

            Assert::isGreaterOrEqual($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsGreaterEqualFailureWithMessageThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotGreaterOrEqualException::class);
            $this->expectExceptionMessage('ad90dfs90uvf90idvfojidvf');

            Assert::isGreaterOrEqual($left, $right, 'ad90dfs90uvf90idvfojidvf');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterEqualValues() */
        public function testIsGreaterEqualThroughValidate($left, $right)
        {
            $this->assertTrue(Validate::isGreaterOrEqual($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerValues() */
        public function testIsGreaterEqualFailureThroughValidate($left, $right)
        {
            $this->assertFalse(Validate::isGreaterOrEqual($left, $right));
        }
    }
