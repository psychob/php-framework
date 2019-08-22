<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\TypeProperties;

    use PHPUnit\Framework\Test;
    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\ClassDoesNotImplementInterfaceException;
    use PsychoB\Framework\Assert\Constraints\TypeProperties\ClassImplementsAssert;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class ClassImplementsAssertTest extends UnitTestCase
    {
        public function provideImplements(): array
        {
            return [
                [$this, Test::class],
            ];
        }

        public function provideDoesntImplement(): array
        {
            return [
                [$this, \Iterator::class],
            ];
        }

        /** @dataProvider provideImplements */
        public function testClassImplements($class, string $implements): void
        {
            ClassImplementsAssert::classImplements($class, $implements);

            $this->assertTrue(true);
        }

        /** @dataProvider provideDoesntImplement */
        public function testClassImplementsFailure($class, string $implements): void
        {
            $this->expectException(ClassDoesNotImplementInterfaceException::class);

            ClassImplementsAssert::classImplements($class, $implements);
        }

        /** @dataProvider provideDoesntImplement */
        public function testClassImplementsFailureWithMessage($class, string $implements): void
        {
            $this->expectException(ClassDoesNotImplementInterfaceException::class);
            $this->expectExceptionMessage('asd90das90das90asd');

            ClassImplementsAssert::classImplements($class, $implements, 'asd90das90das90asd');
        }

        /** @dataProvider provideDoesntImplement */
        public function testClassImplementsException($class, string $implements): void
        {
            $catched = false;

            try {
                ClassImplementsAssert::classImplements($class, $implements);
            } catch (ClassDoesNotImplementInterfaceException $e) {
                $catched = true;

                $this->assertSame($class, $e->getClass());
                $this->assertSame($implements, $e->getInterface());
                $this->assertStringContainsString('does not implement interface', $e->getMessage());
            }

            $this->assertTrue($catched);
        }

        /** @dataProvider provideImplements */
        public function testClassImplementsThroughAssert($class, string $interface): void
        {
            Assert::classImplements($class, $interface);

            $this->assertTrue(true);
        }

        /** @dataProvider provideDoesntImplement */
        public function testClassImplementsFailureThroughAssert($class, string $interface): void
        {
            $this->expectException(ClassDoesNotImplementInterfaceException::class);

            Assert::classImplements($class, $interface);
        }

        /** @dataProvider provideDoesntImplement */
        public function testClassImplementsFailureWithMessageThroughAssert($class, string $interface): void
        {
            $this->expectException(ClassDoesNotImplementInterfaceException::class);
            $this->expectExceptionMessage('asd90das90das90asd');

            Assert::classImplements($class, $interface, 'asd90das90das90asd');
        }

        /** @dataProvider provideImplements */
        public function testClassImplementsThroughValidate($class, string $interface): void
        {
            $this->assertTrue(Validate::classImplements($class, $interface));
        }

        /** @dataProvider provideDoesntImplement */
        public function testClassImplementsFailureThroughValidate($class, string $interface): void
        {
            $this->assertFalse(Validate::classImplements($class, $interface));
        }
    }
