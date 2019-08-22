<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayAssert;
    use PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayHasKeyException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class DontHaveKeyTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testDontHaveKey($arr, $key): void
        {
            ArrayAssert::dontHaveKey($arr, $key);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testDontHaveKeyFailure($arr, $key): void
        {
            $this->expectException(ArrayHasKeyException::class);

            ArrayAssert::dontHaveKey($arr, $key);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testDontHaveKeyFailureWithMessage($arr, $key): void
        {
            $this->expectException(ArrayHasKeyException::class);
            $this->expectExceptionMessage('as9090aa90afs90a0afs');

            ArrayAssert::dontHaveKey($arr, $key, 'as9090aa90afs90a0afs');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testDontHaveKeyException($arr, $key): void
        {
            $catched = false;

            try {
                ArrayAssert::dontHaveKey($arr, $key);
            } catch (ArrayHasKeyException $e) {
                $catched = true;

                $this->assertSame($arr, $e->getArray());
                $this->assertSame($key, $e->getKey());
                $this->assertStringContainsString('have key', $e->getMessage());
            }

            $this->assertTrue($catched);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testDontHaveKeyThroughAssert($arr, $key): void
        {
            Assert::dontHaveKey($arr, $key);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testDontHaveKeyFailureThroughAssert($arr, $key): void
        {
            $this->expectException(ArrayHasKeyException::class);

            Assert::dontHaveKey($arr, $key);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testDontHaveKeyFailureWithMessageThroughAssert($arr, $key): void
        {
            $this->expectException(ArrayHasKeyException::class);
            $this->expectExceptionMessage('as9090aa90afs90a0afs');

            Assert::dontHaveKey($arr, $key, 'as9090aa90afs90a0afs');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testDontHaveKeyThroughValidate($arr, $key): void
        {
            $this->assertTrue(Validate::dontHaveKey($arr, $key));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testDontHaveKeyFailureThroughValidate($arr, $key): void
        {
            $this->assertFalse(Validate::dontHaveKey($arr, $key));
        }
    }
