<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Injector\Injector;

    use PsychoB\Framework\Injector\Container\Container;
    use PsychoB\Framework\Injector\Exceptions\InvalidCallableException;
    use PsychoB\Framework\Injector\Injector\Injector;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mocks\Injector\Injector\NoConstructorMock;

    class InjectorValidateInjectArgumentTest extends UnitTestCase
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

        public function provideInjectWithIncorrectArguments()
        {
            return [
                [1],
                [1.0],
                [['a']],
                [[1]],
                [[1.0]],
                [[1.0, 2, 3]],
                [[1.0, '2']],
                [[1, 2, 3]],
                [[1, '2']],
                [[1, '2']],
                ['foo::bar::'],
                ['::foo'],
                ['bar::'],
            ];
        }

        /** @dataProvider provideInjectWithIncorrectArguments */
        public function testInjectWithIncorrectArguments($inject)
        {
            $this->expectException(InvalidCallableException::class);

            $this->injector->inject($inject);
        }

        public function testMake_ClassWithoutConstructor_ArrayString()
        {
            $class = $this->injector->inject([NoConstructorMock::class, '__construct']);

            $this->assertInstanceOf(NoConstructorMock::class, $class);
        }

        public function testMake_ClassWithoutConstructor_String()
        {
            $class = $this->injector->inject(NoConstructorMock::class . '::__construct');

            $this->assertInstanceOf(NoConstructorMock::class, $class);
        }

        public function testMake_ClassWithoutConstructor_ArrayObject()
        {
            $class = $this->injector->inject([new NoConstructorMock(), '__construct']);

            $this->assertInstanceOf(NoConstructorMock::class, $class);
        }
    }
