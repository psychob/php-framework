<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\EmptinessAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\EmptinessAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValueIsFullException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    /**
     * @covers \PsychoB\Framework\Assert\Constraints\Value\EmptinessAssert
     * @covers \PsychoB\Framework\Assert\Constraints\Value\ValueIsFullException
     */
    class IsEmptyTest extends UnitTestCase
    {
        public function testIsEmpty(): void
        {
            EmptinessAssert::isEmpty([]);

            $this->assertTrue(true);
        }

        public function testIsEmptyFailure(): void
        {
            $this->expectException(ValueIsFullException::class);

            EmptinessAssert::isEmpty(['a']);
        }

        public function testIsEmptyThroughAssert(): void
        {
            Assert::isEmpty([]);

            $this->assertTrue(true);
        }

        public function testIsEmptyThroughAssertFailure(): void
        {
            $this->expectException(ValueIsFullException::class);

            Assert::isEmpty([1]);
        }

        public function testIsEmptyThroughValidator(): void
        {
            $this->assertTrue(Validate::isEmpty([]));
        }

        public function testIsEmptyThroughValidatorFailure(): void
        {
            $this->assertFalse(Validate::isEmpty([1]));
        }

        public function testIsEmptyException(): void
        {
            $catched = false;

            try {
                EmptinessAssert::isEmpty([1]);
            } catch (ValueIsFullException $e) {
                $catched = true;

                $this->assertSame([1], $e->getValue());
            }

            $this->assertTrue($catched);
        }
    }
