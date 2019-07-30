<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\IsTrueAssert;
    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Assert\Exception\ValueIsNotTrueException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\IsTrueAssert
     * @covers \PsychoB\Framework\Assert\Exception\ValueIsNotTrueException
     */
    class IsTrueAssertTest extends UnitTestCase
    {
        public function provideEnsureGood()
        {
            return [
                [true],
            ];
        }

        /** @dataProvider provideEnsureGood */
        public function testEnsureGood($obj)
        {
            IsTrueAssert::ensure($obj);
            $this->assertTrue(true);
        }

        public function provideEnsureBad()
        {
            return [
                [false],
                [1],
                ['true'],
            ];
        }

        /** @dataProvider provideEnsureBad */
        public function testEnsureBad($obj)
        {
            $this->expectException(ValueIsNotTrueException::class);
            IsTrueAssert::ensure($obj);
        }

        /** @dataProvider provideEnsureGood */
        public function testValidateGood($obj)
        {
            $this->assertTrue(Validate::isTrue($obj));
        }

        /** @dataProvider provideEnsureBad */
        public function testValidateBad($obj)
        {
            $this->assertFalse(Validate::isTrue($obj));
        }

        /** @dataProvider provideEnsureBad */
        public function testEnsureBadCheckException($obj)
        {
            $catch = false;

            try {
                Assert::isTrue($obj);
            } catch (ValueIsNotTrueException $e) {
                $this->assertInstanceOf(AssertionException::class, $e);
                $this->assertSame($obj, $e->getValue());

                $catch = true;
            }

            $this->assertTrue($catch);
        }
    }
