<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DependencyInjection\Injector;

    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;
    use PsychoB\Framework\DependencyInjection\Relation\RelationDatabase;
    use PsychoB\Framework\Testing\UnitTestCase;
    use ReflectionClass;
    use Tests\PsychoB\Framework\Mocks\DependencyInjection\Injector\EmptyConstructorMock;
    use Tests\PsychoB\Framework\Mocks\DependencyInjection\Injector\NoConstructorMock;

    class InjectorTest extends UnitTestCase
    {
        /**
         * @var Injector
         */
        private $injector;

        protected function setUp(): void
        {
            parent::setUp();

            $this->injector = new Injector(new Container(), new RelationDatabase());
        }

        public function testInjectIntoNoConstructorClass()
        {
            $this->assertInstanceOf(NoConstructorMock::class,
                                    $this->injector->inject([NoConstructorMock::class, '__construct']));
        }


        public function testInjectIntoEmptyConstructorClass()
        {
            $this->assertInstanceOf(EmptyConstructorMock::class,
                                    $this->injector->inject([EmptyConstructorMock::class, '__construct']));
        }

        public function testInjectIntoAnonymousClassWithoutConstructorDefined()
        {
            $newAnonClass = $this->injector->inject([new class
            {
            }, '__construct']);

            $this->assertIsObject($newAnonClass);
            $this->assertTrue((new ReflectionClass($newAnonClass))->isAnonymous());
        }

        public function testInjectIntoAnonymousClassWithConstructorDefined()
        {
            $newAnonClass = $this->injector->inject([new class
            {
                public function __construct()
                {
                }
            }, '__construct']);

            $this->assertIsObject($newAnonClass);
            $this->assertTrue((new ReflectionClass($newAnonClass))->isAnonymous());
        }
    }
