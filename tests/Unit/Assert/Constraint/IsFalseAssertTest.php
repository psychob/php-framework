<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\IsFalseAssert;
    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Assert\Exception\ValueIsNotFalseException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\IsFalseAssert
     * @covers \PsychoB\Framework\Assert\Exception\ValueIsNotFalseException
     */
    class IsFalseAssertTest extends UnitTestCase
    {
        public function provideEnsureGood()
        {
            return [
                [false],
            ];
        }

        /** @dataProvider provideEnsureGood */
        public function testEnsureGood($obj)
        {
            IsFalseAssert::ensure($obj);
            $this->assertTrue(true);
        }

        public function provideEnsureBad()
        {
            return [
                [true],
                [0],
                [[]],
            ];
        }

        /** @dataProvider provideEnsureBad */
        public function testEnsureBad($obj)
        {
            $this->expectException(ValueIsNotFalseException::class);
            IsFalseAssert::ensure($obj);
        }

        /** @dataProvider provideEnsureGood */
        public function testValidateGood($obj)
        {
            $this->assertTrue(Validate::isFalse($obj));
        }

        /** @dataProvider provideEnsureBad */
        public function testValidateBad($obj)
        {
            $this->assertFalse(Validate::isFalse($obj));
        }

        /** @dataProvider provideEnsureBad */
        public function testEnsureBadCheckException($obj)
        {
            $catch = false;

            try {
                Assert::isFalse($obj);
            } catch (ValueIsNotFalseException $e) {
                $this->assertInstanceOf(AssertionException::class, $e);
                $this->assertSame($obj, $e->getValue());

                $catch = true;
            }

            $this->assertTrue($catch);
        }
    }
