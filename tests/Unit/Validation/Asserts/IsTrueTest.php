<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Validation\Asserts;

    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Validation\Asserts\Exception\BaseAssert;
    use PsychoB\Framework\Validation\Asserts\Exception\ValueIsNotTrueAssert;
    use PsychoB\Framework\Validation\Asserts\IsTrue;

    class IsTrueTest extends UnitTestCase
    {
        public function provideEnsureException()
        {
            return [
                [false,],
                [1,],
                ['true',],
                [new class
                {
                },],
            ];
        }

        /** @dataProvider provideEnsureException */
        public function testEnsureException($obj): void
        {
            $this->expectException(ValueIsNotTrueAssert::class);

            IsTrue::ensure($obj);
        }

        public function provideEnsure()
        {
            return [
                [true,],
            ];
        }

        /** @dataProvider provideEnsure */
        public function testEnsure($obj): void
        {
            IsTrue::ensure($obj);

            // Above method will not return anything, but it will also not throw anything, so to test this we just set
            // up this dummy assert
            $this->assertTrue(true);
        }

        public function provideValidate()
        {
            return [
                [true, true],
                [false, false,],
                [1, false,],
                ['true', false,],
                [new class
                {
                }, false,],
            ];
        }

        /** @dataProvider provideValidate */
        public function testValidate($obj, bool $result): void
        {
            $this->assertSame(IsTrue::validate($obj), $result);
        }

        public function testExceptionObject_NoMessage()
        {
            $catch = false;

            try {
                IsTrue::ensure(false);
            } catch (ValueIsNotTrueAssert $e) {
                $catch = true;

                $this->assertInstanceOf(BaseAssert::class, $e);
                $this->assertSame('isTrue', $e->getAssertName());
                $this->assertSame(false, $e->getValue());
                $this->assertNotRegExp('/Oh No!/', $e->getMessage());
            }

            $this->assertTrue($catch, 'Proper exception was not thrown');
        }

        public function testExceptionObject_Message()
        {
            $catch = false;

            try {
                IsTrue::ensure(false, 'Oh No!');
            } catch (ValueIsNotTrueAssert $e) {
                $catch = true;

                $this->assertInstanceOf(BaseAssert::class, $e);
                $this->assertSame('isTrue', $e->getAssertName());
                $this->assertSame(false, $e->getValue());
                $this->assertRegExp('/Oh No!/', $e->getMessage());
            }

            $this->assertTrue($catch, 'Proper exception was not thrown');
        }
    }
