<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing;

    use PHPUnit\Framework\TestCase as PhpUnitTestCase;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Ref;
    use PsychoB\Framework\Utility\Str;

    class UnitTestCase extends PhpUnitTestCase
    {
        use ArrayAssertTrait, VirtualSystemAssertTrait;

        private static $_pbfw_traits_to_set_up__ = [];

        public static function setUpBeforeClass(): void
        {
            parent::setUpBeforeClass();

            foreach (Ref::lazyRecursiveTraits(static::class) as $trait) {
                if (Str::endsWith($trait->getShortName(), 'TestCaseTrait')) {
                    self::$_pbfw_traits_to_set_up__[] = $trait->getShortName();
                }
            }

            self::$_pbfw_traits_to_set_up__ = Arr::sortByCustom(self::$_pbfw_traits_to_set_up__,
                function (string $trait): int {
                    return call_user_func([static::class, sprintf('%s_priority', $trait)]);
                });
        }

        public static function tearDownAfterClass(): void
        {
            self::$_pbfw_traits_to_set_up__ = [];
            parent::tearDownAfterClass();
        }

        protected function setUp(): void
        {
            parent::setUp();

            foreach (self::$_pbfw_traits_to_set_up__ as $traitToSetUp) {
                call_user_func([$this, sprintf('%s_setUp', $traitToSetUp)]);
            }
        }

        protected function tearDown(): void
        {
            foreach (self::$_pbfw_traits_to_set_up__ as $traitToTearDown) {
                call_user_func([$this, sprintf('%s_tearDown', $traitToTearDown)]);
            }

            if ($container = \Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            \Mockery::close();

            parent::tearDown();
        }
    }
