<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Core\ErrorHandling;

    use PsychoB\Framework\Core\ErrorHandling\DumbErrorHandler;
    use PsychoB\Framework\Core\Exceptions\PHPErrorException;
    use PsychoB\Framework\Testing\UnitTestCase;

    class DumbErrorHandlerTest extends UnitTestCase
    {
        static private $old;

        protected function setUp(): void
        {
            parent::setUp();

            static::$old = set_error_handler([static::class, 'handle']);
        }

        protected function tearDown(): void
        {
            set_error_handler(static::$old);

            parent::tearDown();
        }

        public function testRegistration()
        {
            $eh = new DumbErrorHandler();
            $eh->register();

            $our = set_error_handler([static::class, 'handle']);

            $this->assertInstanceOf(DumbErrorHandler::class, $our[0], 'Different type of Error Handler');
            $this->assertEquals($eh, $our[0], 'Different Instance of Error Handler');
            $this->assertSame('handle', $our[1], 'Diffrent Error Handler method');
        }

        public function testException()
        {
            (new DumbErrorHandler())->register();

            $this->expectException(PHPErrorException::class);
            /** @noinspection PhpUndefinedVariableInspection */
            /** @noinspection PhpUnusedLocalVariableInspection */
            $foo = $unknownVariable;
        }

        public function testExceptionSilenced()
        {
            (new DumbErrorHandler())->register();

            /** @noinspection PhpUndefinedVariableInspection */
            /** @noinspection PhpUnusedLocalVariableInspection */
            $foo = @$unknownVariable;

            $this->assertTrue(true);
        }

        public static function handle()
        {
            // we just want to redirect to old handler in case of exception that our handler didn't catchd
            call_user_func_array(static::$old->old, func_get_args());
        }
    }
