<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint;

    use PsychoB\Framework\Assert\Constraints\IsEqualAssert;
    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Assert\Exception\ValueIsNotEqualException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\IsEqualAssert
     * @covers \PsychoB\Framework\Assert\Exception\ValueIsNotEqualException
     */
    class IsEqualAssertTest extends UnitTestCase
    {
        public function provideEnsureGood()
        {
            return [
                [true, true,],
                [false, false],
            ];
        }

        /** @dataProvider provideEnsureGood */
        public function testEnsureGood($left, $right)
        {
            IsEqualAssert::ensure($left, $right);
            $this->assertTrue(true);
        }

        public function provideEnsureBad()
        {
            return [
                [true, false],
                [true, 1],
                ['true', 1],
                ['1', 1],
            ];
        }

        /** @dataProvider provideEnsureBad */
        public function testEnsureBad($left, $right)
        {
            $this->expectException(ValueIsNotEqualException::class);
            IsEqualAssert::ensure($left, $right);
        }

        /** @dataProvider provideEnsureGood */
        public function testValidateGood($left, $right)
        {
            $this->assertTrue(Validate::isEqual($left, $right));
        }

        /** @dataProvider provideEnsureBad */
        public function testValidateBad($left, $right)
        {
            $this->assertFalse(Validate::isEqual($left, $right));
        }

        /** @dataProvider provideEnsureBad */
        public function testEnsureBadCheckException($left, $right)
        {
            $catch = false;

            try {
                IsEqualAssert::ensure($left, $right);
            } catch (ValueIsNotEqualException $e) {
                $this->assertInstanceOf(AssertionException::class, $e);
                $this->assertSame($left, $e->getValue());
                $this->assertSame($right, $e->getCompare());

                $catch = true;
            }

            $this->assertTrue($catch);
        }
    }
