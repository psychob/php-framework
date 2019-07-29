<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing;

    use PHPUnit\Framework\TestCase as PhpUnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class UnitTestCase extends PhpUnitTestCase
    {
        use ArrayAssertTrait, VirtualSystemAssertTrait;

        protected static $__traitsToSetUp = [];

        public static function setUpBeforeClass(): void
        {
            parent::setUpBeforeClass();

            $reflection = new \ReflectionClass(static::class);
            foreach ($reflection->getTraits() as $trait) {
                if (Str::endsWith($trait->getName(), 'TestCaseTrait')) {
                    self::$__traitsToSetUp[] = $trait->getShortName();
                }
            }
        }

        public static function tearDownAfterClass(): void
        {
            self::$__traitsToSetUp = [];
            parent::tearDownAfterClass();
        }

        protected function setUp(): void
        {
            parent::setUp();

            foreach (self::$__traitsToSetUp as $traitToSetUp) {
                call_user_func([$this, sprintf('%s_setUp', $traitToSetUp)]);
            }
        }

        protected function tearDown(): void
        {
            foreach (self::$__traitsToSetUp as $traitToTearDown) {
                call_user_func([$this, sprintf('%s_tearDown', $traitToTearDown)]);
            }

            if ($container = \Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            \Mockery::close();

            parent::tearDown();
        }
    }
