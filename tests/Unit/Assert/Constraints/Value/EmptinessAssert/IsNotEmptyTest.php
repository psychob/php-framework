<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Value\EmptinessAssert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Value\EmptinessAssert;
    use PsychoB\Framework\Assert\Constraints\Value\ValueIsEmptyException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class IsNotEmptyTest extends UnitTestCase
    {
        public function testisNotEmpty(): void
        {
            EmptinessAssert::isNotEmpty([1]);

            $this->assertTrue(true);
        }

        public function testisNotEmptyFailure(): void
        {
            $this->expectException(ValueIsEmptyException::class);

            EmptinessAssert::isNotEmpty([]);
        }

        public function testisNotEmptyThroughAssert(): void
        {
            Assert::notEmpty(['1']);

            $this->assertTrue(true);
        }

        public function testisNotEmptyThroughAssertFailure(): void
        {
            $this->expectException(ValueIsEmptyException::class);

            Assert::notEmpty([]);
        }

        public function testisNotEmptyThroughValidator(): void
        {
            $this->assertTrue(Validate::notEmpty([1]));
        }

        public function testisNotEmptyThroughValidatorFailure(): void
        {
            $this->assertFalse(Validate::notEmpty([]));
        }

        public function testisNotEmptyException(): void
        {
            $catched = false;

            try {
                EmptinessAssert::isNotEmpty([]);
            } catch (ValueIsEmptyException $e) {
                $catched = true;

                $this->assertSame([], $e->getValue());
            }

            $this->assertTrue($catched);
        }
    }
