<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValueIsNotGreaterException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class IsGreaterTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsGreater($left, $right)
        {
            ComparisionAssert::isGreater($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsGreaterFailure($left, $right)
        {
            $this->expectException(ValueIsNotGreaterException::class);

            ComparisionAssert::isGreater($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsGreaterFailureWithMessage($left, $right)
        {
            $this->expectException(ValueIsNotGreaterException::class);
            $this->expectExceptionMessage('asd89das89dasnuidasnuidas');

            ComparisionAssert::isGreater($left, $right, 'asd89das89dasnuidasnuidas');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsGreaterException($left, $right)
        {
            $catched = false;

            try {
                ComparisionAssert::isGreater($left, $right);
            } catch (ValueIsNotGreaterException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertFalse($e->isStrict());
                $this->assertStringContainsString('is not greater then', $e->getMessage());
            }

            $this->assertTrue($catched);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsGreaterThroughAssert($left, $right)
        {
            Assert::isGreater($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsGreaterFailureThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotGreaterException::class);

            Assert::isGreater($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsGreaterFailureWithMessageThroughAssert($left, $right)
        {
            $this->expectException(ValueIsNotGreaterException::class);
            $this->expectExceptionMessage('ad90dfs90uvf90idvfojidvf');

            Assert::isGreater($left, $right, 'ad90dfs90uvf90idvfojidvf');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideGreaterValues() */
        public function testIsGreaterThroughValidate($left, $right)
        {
            $this->assertTrue(Validate::isGreater($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSmallerEqualValues() */
        public function testIsGreaterFailureThroughValidate($left, $right)
        {
            $this->assertFalse(Validate::isGreater($left, $right));
        }
    }
