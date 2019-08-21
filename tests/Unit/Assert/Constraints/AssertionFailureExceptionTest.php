<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints;

    use Mockery\MockInterface;
    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use PsychoB\Framework\Exception\BaseException;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Throwable;

    /** @covers \PsychoB\Framework\Assert\Constraints\AssertionFailureException */
    class AssertionFailureExceptionTest extends UnitTestCase
    {
        public function testTypeConstraints()
        {
            $exp = \Mockery::mock(AssertionFailureException::class, [
                'foo',
                'bar',
            ])->makePartial();

            $this->assertInstanceOf(AssertionFailureException::class, $exp);
            $this->assertInstanceOf(BaseException::class, $exp);
            $this->assertInstanceOf(Throwable::class, $exp);
        }

        public function testStandardExceptionMechanism()
        {
            $previousException = new \Exception('x');
            /** @var AssertionFailureException|MockInterface $exp */
            $exp = \Mockery::mock(AssertionFailureException::class, [
                'foo',
                'bar',
                NULL,
                2137,
                $previousException,
            ])->makePartial();

            $this->assertInstanceOf(\Exception::class, $exp->getPrevious());
            $this->assertSame($previousException, $exp->getPrevious());
            $this->assertSame(2137, $exp->getCode());
        }

        public function testCustomExceptionMechanism()
        {
            /** @var AssertionFailureException|MockInterface $exp */
            $exp = \Mockery::mock(AssertionFailureException::class, [
                'assert-foo',
                'Something bad happend',
                NULL,
            ])->makePartial();

            $this->assertSame('assert-foo', $exp->getAssertionType());
            $this->assertSame('Something bad happend', $exp->getExceptionMessage());
            $this->assertNull($exp->getCustomMessage());
            $this->assertStringContainsString('Something bad happend', $exp->getMessage());

            /** @var AssertionFailureException|MockInterface $exp */
            $exp = \Mockery::mock(AssertionFailureException::class, [
                'assert-foo',
                'Something bad happend',
                'Even more bad',
            ])->makePartial();

            $this->assertSame('assert-foo', $exp->getAssertionType());
            $this->assertSame('Something bad happend', $exp->getExceptionMessage());
            $this->assertSame('Even more bad', $exp->getCustomMessage());
            $this->assertStringContainsString('Something bad happend', $exp->getMessage());
            $this->assertStringContainsString('Even more bad', $exp->getMessage());
        }
    }
