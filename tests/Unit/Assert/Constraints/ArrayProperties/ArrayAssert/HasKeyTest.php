<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayAssert;
    use PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayDontHaveKeyException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayAssert
     * @covers \PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayAssertException
     * @covers \PsychoB\Framework\Assert\Constraints\ArrayProperties\ArrayDontHaveKeyException
     */
    class HasKeyTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testHasKey($arr, $key): void
        {
            ArrayAssert::hasKey($arr, $key);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testHasKeyFailure($arr, $key): void
        {
            $this->expectException(ArrayDontHaveKeyException::class);

            ArrayAssert::hasKey($arr, $key);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testHasKeyFailureWithMessage($arr, $key): void
        {
            $this->expectException(ArrayDontHaveKeyException::class);
            $this->expectExceptionMessage('as9090aa90afs90a0afs');

            ArrayAssert::hasKey($arr, $key, 'as9090aa90afs90a0afs');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testHasKeyException($arr, $key): void
        {
            $catched = false;

            try {
                ArrayAssert::hasKey($arr, $key);
            } catch (ArrayDontHaveKeyException $e) {
                $catched = true;

                $this->assertSame($arr, $e->getArray());
                $this->assertSame($key, $e->getKey());
                $this->assertStringContainsString('do not have key', $e->getMessage());
            }

            $this->assertTrue($catched);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testHasKeyThroughAssert($arr, $key): void
        {
            Assert::hasKey($arr, $key);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testHasKeyFailureThroughAssert($arr, $key): void
        {
            $this->expectException(ArrayDontHaveKeyException::class);

            Assert::hasKey($arr, $key);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testHasKeyFailureWithMessageThroughAssert($arr, $key): void
        {
            $this->expectException(ArrayDontHaveKeyException::class);
            $this->expectExceptionMessage('as9090aa90afs90a0afs');

            Assert::hasKey($arr, $key, 'as9090aa90afs90a0afs');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithKeys() */
        public function testHasKeyThroughValidate($arr, $key): void
        {
            $this->assertTrue(Validate::hasKey($arr, $key));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\ArrayProperties\ArrayAssert\ArrayAssertProvider::provideWithoutKeys() */
        public function testHasKeyFailureThroughValidate($arr, $key): void
        {
            $this->assertFalse(Validate::hasKey($arr, $key));
        }
    }
