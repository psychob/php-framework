<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraints\Other;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\Other\UnreachableAssert;
    use PsychoB\Framework\Assert\Constraints\Other\UnreachableAssertException;
    use PsychoB\Framework\Assert\Exception\AssertNotFoundException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class UnreachableAssertTest extends UnitTestCase
    {
        public function testEnsure()
        {
            $this->expectException(UnreachableAssertException::class);

            UnreachableAssert::ensure();
        }

        public function testEnsureWithMessage()
        {
            $this->expectException(UnreachableAssertException::class);
            $this->expectExceptionMessage('dfasonidfas90jdfaswo90jidvfasklj');

            UnreachableAssert::ensure('dfasonidfas90jdfaswo90jidvfasklj');
        }

        public function testEnsureThroughAssert()
        {
            $this->expectException(UnreachableAssertException::class);

            Assert::unreachable();
        }

        public function testEnsureThroughAssertWithMessage()
        {
            $this->expectException(UnreachableAssertException::class);
            $this->expectExceptionMessage('dfasonidfas90jdfaswo90jidvfasklj');

            Assert::unreachable('dfasonidfas90jdfaswo90jidvfasklj');
        }

        public function testEnsureThroughValidate()
        {
            $this->expectException(AssertNotFoundException::class);

            Validate::unreachable();
        }

        public function testEnsureThroughValidateWithMessage()
        {
            $this->expectException(AssertNotFoundException::class);

            Validate::unreachable('dfasonidfas90jdfaswo90jidvfasklj');
        }
    }
