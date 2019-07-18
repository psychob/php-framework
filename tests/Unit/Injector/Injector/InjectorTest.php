<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Injector\Injector;

    use PsychoB\Framework\Injector\Container\Container;
    use PsychoB\Framework\Injector\Injector\Injector;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mocks\Injector\Injector\EmptyConstructorMock;
    use Tests\PsychoB\Framework\Mocks\Injector\Injector\NoConstructorMock;
    use Tests\PsychoB\Framework\Mocks\Injector\Injector\SimpleConstructorMock;

    class InjectorTest extends UnitTestCase
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

        public function testCreate_ClassWithoutConstructor()
        {
            $this->assertInstanceOf(NoConstructorMock::class, $this->injector->inject([NoConstructorMock::class, '__construct']));
        }

        public function testCreate_ClassWithConstructorWithoutArgument()
        {
            $this->assertInstanceOf(EmptyConstructorMock::class, $this->injector->inject([EmptyConstructorMock::class, '__construct']));
        }

        public function testCreate_ClassWithSimpleConstructor()
        {
            $this->assertInstanceOf(SimpleConstructorMock::class, $this->injector->inject([SimpleConstructorMock::class, '__construct']));
        }
    }
