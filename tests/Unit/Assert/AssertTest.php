<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Exception\AssertNotFoundException;
    use PsychoB\Framework\Testing\UnitTestCase;

    class AssertTest extends UnitTestCase
    {
        public function testRealConstraint()
        {
            Assert::isTrue(true);
            $this->assertTrue(true);
        }

        public function testConstraintThatDosentExist()
        {
            $this->expectException(AssertNotFoundException::class);
            Assert::dosentExistsConstraint(true);
        }
    }
