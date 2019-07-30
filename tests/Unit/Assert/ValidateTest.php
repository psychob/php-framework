<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Exception\AssertNotFoundException;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Testing\UnitTestCase;

    class ValidateTest extends UnitTestCase
    {
        public function testRealConstraint()
        {
            $this->assertTrue(Validate::isTrue(true));
            $this->assertFalse(Validate::isTrue(false));
        }

        public function testConstraintThatDosentExist()
        {
            $this->expectException(AssertNotFoundException::class);
            Validate::dosentExistsConstraint(true);
        }
    }
