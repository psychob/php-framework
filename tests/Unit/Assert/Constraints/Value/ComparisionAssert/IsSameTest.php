<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValuesAreDifferentException;
    use PsychoB\Framework\Assert\Constraints\Value\ValuesAreSameException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class IsSameTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsSame($left, $right): void
        {
            ComparisionAssert::isSame($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsSameFailure($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);

            ComparisionAssert::isSame($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsSameFailureWithMessage($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            ComparisionAssert::isSame($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsSameThroughAssert($left, $right): void
        {
            Assert::isSame($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsSameFailureThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);

            Assert::isSame($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsSameFailureWithMessageThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreDifferentException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            Assert::isSame($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsSameThroughValidate($left, $right): void
        {
            $this->assertTrue(Validate::isSame($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsSameFailureThroughValidate($left, $right): void
        {
            $this->assertFalse(Validate::isSame($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsSameException($left, $right): void
        {
            $catched = false;

            try {
                ComparisionAssert::isSame($left, $right);
            } catch (ValuesAreDifferentException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertTrue($e->isStrict());
            }

            $this->assertTrue($catched);
        }
    }
