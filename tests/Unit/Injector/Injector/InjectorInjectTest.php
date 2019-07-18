<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Injector\Injector;

    use PsychoB\Framework\Injector\Container\Container;
    use PsychoB\Framework\Injector\Exceptions\CanNotResolveArgumentException;
    use PsychoB\Framework\Injector\Exceptions\StaticCallOfNonStaticFunctionException;
    use PsychoB\Framework\Injector\Injector\Injector;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mocks\Injector\Injector\FunctionInjectMock;

    class InjectorInjectTest extends UnitTestCase
    {
        /**
         * @var Container
         */
        private $container;

        /**
         * @var Injector
         */
        private $injector;

        protected function setUp(): void
        {
            parent::setUp();

            $this->container = new Container();
            $this->injector = new Injector($this->container);
        }

        public function testInjectStaticMethod_CallWithClass()
        {
            $this->assertSame('staticFunctionWithoutArguments',
                              $this->injector->inject([FunctionInjectMock::class, 'staticFunctionWithoutArguments']));
        }

        public function testInjectStaticMethod_CallWithObject()
        {
            $mock = new FunctionInjectMock();

            $this->assertSame('staticFunctionWithoutArguments',
                              $this->injector->inject([$mock, 'staticFunctionWithoutArguments']));
        }

        public function testInjectNormalMethod_CallWithClass()
        {
            $this->expectException(StaticCallOfNonStaticFunctionException::class);
            $this->assertSame('functionWithoutArguments',
                              $this->injector->inject([FunctionInjectMock::class, 'functionWithoutArguments']));
        }

        public function testInjectNormalMethod_CallWithObject()
        {
            $mock = new FunctionInjectMock();

            $this->assertSame('functionWithoutArguments',
                              $this->injector->inject([$mock, 'functionWithoutArguments']));
        }

        public function testInject_AutoWire()
        {
            $mock = new FunctionInjectMock();

            $this->assertSame('autoWiredMethod',
                              $this->injector->inject([$mock, 'autoWiredMethod']));
        }

        public function testInject_PartialAutoWire_Failed()
        {
            $this->expectException(CanNotResolveArgumentException::class);

            $mock = new FunctionInjectMock();

            $this->assertSame('partialAutoWire',
                              $this->injector->inject([$mock, 'partialAutoWire']));
        }

        public function testInject_PartialAutoWire_Good()
        {
            $mock = new FunctionInjectMock();

            $this->assertSame('partialAutoWire',
                              $this->injector->inject([$mock, 'partialAutoWire'], [
                                  2 => 42,
                                  'greatest' => 'string of all time',
                              ]));
        }

        public function testInject_WithDefaultValues()
        {
            $mock = new FunctionInjectMock();

            $this->assertSame('withDefaultValues',
                              $this->injector->inject([$mock, 'withDefaultValues']));
        }
    }
