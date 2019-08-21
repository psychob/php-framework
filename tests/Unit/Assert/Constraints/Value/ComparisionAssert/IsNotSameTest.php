<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\ComparisionAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValuesAreSameException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class IsNotSameTest extends UnitTestCase
    {
        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsNotSame($left, $right): void
        {
            ComparisionAssert::isNotSame($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsNotSameFailure($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);

            ComparisionAssert::isNotSame($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsNotSameFailureWithMessage($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            ComparisionAssert::isNotSame($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsNotSameThroughAssert($left, $right): void
        {
            Assert::notSame($left, $right);

            $this->assertTrue(true);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsNotSameFailureThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);

            Assert::notSame($left, $right);
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsNotSameFailureWithMessageThroughAssert($left, $right): void
        {
            $this->expectException(ValuesAreSameException::class);
            $this->expectExceptionMessage('ads8asd89das89');

            Assert::notSame($left, $right, 'ads8asd89das89');
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideNotSameValues() */
        public function testIsNotSameThroughValidate($left, $right): void
        {
            $this->assertTrue(Validate::notSame($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsNotSameFailureThroughValidate($left, $right): void
        {
            $this->assertFalse(Validate::notSame($left, $right));
        }

        /** @dataProvider \Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\ComparisionAssert\ComparisionAssertProviders::provideSameValues() */
        public function testIsNotSameException($left, $right): void
        {
            $catched = false;

            try {
                ComparisionAssert::isNotSame($left, $right);
            } catch (ValuesAreSameException $e) {
                $catched = true;

                $this->assertSame($left, $e->getLeft());
                $this->assertSame($right, $e->getRight());
                $this->assertTrue($e->isStrict());
            }

            $this->assertTrue($catched);
        }
    }
