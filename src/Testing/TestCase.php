<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing;

    use PHPUnit\Framework\TestCase as PhpUnitTestCase;

    class TestCase extends PhpUnitTestCase
    {
        protected function tearDown(): void
        {
            if ($container = \Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            \Mockery::close();

            parent::tearDown();
        }
    }
