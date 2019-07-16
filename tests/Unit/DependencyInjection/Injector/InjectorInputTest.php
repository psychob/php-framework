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
    use Tests\PsychoB\Framework\Mocks\DependencyInjection\Injector\EmptyConstructorMock;
    use Tests\PsychoB\Framework\Mocks\DependencyInjection\Injector\NoConstructorMock;
    use Tests\PsychoB\Framework\Mocks\DependencyInjection\Injector\SimpleConstructorMock;

    class InjectorInputTest extends UnitTestCase
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

        public function testArraySyntaxConstructor()
        {
            $this->assertInstanceOf(NoConstructorMock::class,
                                    $this->injector->inject([NoConstructorMock::class, '__construct']));

            $this->assertInstanceOf(EmptyConstructorMock::class,
                                    $this->injector->inject([EmptyConstructorMock::class, '__construct']));

            $this->assertInstanceOf(SimpleConstructorMock::class,
                                    $this->injector->inject([SimpleConstructorMock::class, '__construct']));
        }

        public function testStringSyntaxConstructor()
        {
            $this->assertInstanceOf(NoConstructorMock::class,
                                    $this->injector->inject(NoConstructorMock::class . '::__construct'));

            $this->assertInstanceOf(EmptyConstructorMock::class,
                                    $this->injector->inject(EmptyConstructorMock::class . '::__construct'));

            $this->assertInstanceOf(SimpleConstructorMock::class,
                                    $this->injector->inject(SimpleConstructorMock::class . '::__construct'));
        }

        public function testFunction()
        {
            $this->assertInstanceOf(NoConstructorMock::class, $this->injector->inject(function () {
                return new NoConstructorMock();
            }));

            $this->assertInstanceOf(SimpleConstructorMock::class, $this->injector->inject(function (EmptyConstructorMock $empty) {
                return new SimpleConstructorMock($empty);
            }));
        }
    }
