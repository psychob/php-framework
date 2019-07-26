<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DependencyInjection\Injector;

    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\AmbiguousInjectionException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\CircularDependencyDetectedException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\InjectArgumentNotFoundException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\InvalidCallableException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\StaticCallNormalMethodException;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;
    use PsychoB\Framework\DependencyInjection\Resolver\DeferredResolver;
    use PsychoB\Framework\DependencyInjection\Resolver\Resolver;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\EmptyConstructorMock;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\NoConstructorMock;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\NonDirectCircularDependencyMock;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\NonStaticInjectMock;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\SimpleBulitinBasedConstructorMock;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\SimpleCircularDependencyMock;
    use Tests\PsychoB\Framework\Mock\DependencyInjection\Injector\SimpleClassBasedConstructorMock;

    class InjectorTest extends UnitTestCase
    {
        /** @var Injector */
        private $injector;

        protected function setUp(): void
        {
            parent::setUp();

            $def = new DeferredResolver();
            $cont = new Container();
            $this->injector = new Injector($cont, $def);
            $config = \Mockery::mock(ConfigManagerInterface::class);
            $res = new Resolver($cont, $this->injector, $config);
            $def->setResolver($res);
        }

        public function provideInput(): array
        {
            return [
                [[]],
                [['fnc']],
                [['fnc', 'method', 'arg?']],
                [['fnc', 1337]],
                [['fnc', true]],
                [[1337, 'method']],
                [true],
                [1337],
            ];
        }

        /** @dataProvider provideInput */
        public function testInput($input)
        {
            $this->expectException(InvalidCallableException::class);
            $this->injector->inject($input);
        }

        public function testInject_New_NoConstructor()
        {
            $this->assertInstanceOf(NoConstructorMock::class, $this->injector->make(NoConstructorMock::class));
        }

        public function testInject_New_EmptyConstructor()
        {
            $this->assertInstanceOf(EmptyConstructorMock::class, $this->injector->make(EmptyConstructorMock::class));
        }

        public function testInject_New_SimpleClassBasedConstructorMock()
        {
            $this->assertInstanceOf(SimpleClassBasedConstructorMock::class,
                                    $this->injector->make(SimpleClassBasedConstructorMock::class));
        }

        public function testInject_New_SimpleBuiltinBasedConstructorMock_WithoutArguments()
        {
            $this->expectException(InjectArgumentNotFoundException::class);

            $this->assertInstanceOf(SimpleBulitinBasedConstructorMock::class,
                                    $this->injector->make(SimpleBulitinBasedConstructorMock::class));
        }

        public function testInject_New_SimpleBuiltinBasedConstructorMock_WithNumberedArguments()
        {
            $this->assertInstanceOf(SimpleBulitinBasedConstructorMock::class,
                                    $this->injector->make(SimpleBulitinBasedConstructorMock::class, [
                                        10, '10',
                                    ]));
        }

        public function testInject_New_SimpleBuiltinBasedConstructorMock_WithNamedArguments()
        {
            $this->assertInstanceOf(SimpleBulitinBasedConstructorMock::class,
                                    $this->injector->make(SimpleBulitinBasedConstructorMock::class, [
                                        'int'    => 10,
                                        'string' => '10',
                                    ]));
        }

        public function testInject_New_SimpleBuiltinBasedConstructorMock_Ambiguous()
        {
            $this->expectException(AmbiguousInjectionException::class);
            $this->assertInstanceOf(SimpleBulitinBasedConstructorMock::class,
                                    $this->injector->make(SimpleBulitinBasedConstructorMock::class, [
                                        20, '20',
                                        'int'    => 10,
                                        'string' => '10',
                                    ]));
        }

        public function testInject_New_SimpleCircularDependencyMock_CircularDependency()
        {
            $this->expectException(CircularDependencyDetectedException::class);
            $this->assertInstanceOf(SimpleCircularDependencyMock::class,
                                    $this->injector->make(SimpleCircularDependencyMock::class));
        }

        public function testInject_New_NonDirectCircularDependencyMock_CircularDependency()
        {
            $this->expectException(CircularDependencyDetectedException::class);
            $this->assertInstanceOf(NonDirectCircularDependencyMock::class,
                                    $this->injector->make(NonDirectCircularDependencyMock::class));
        }

        public function testInject_New_SimpleClassBasedConstructorMock_AsString()
        {
            $this->assertInstanceOf(SimpleClassBasedConstructorMock::class,
                                    $this->injector->inject(SimpleClassBasedConstructorMock::class . '::__construct'));
        }

        public function testInject_Inject_Callable()
        {
            $this->assertInstanceOf(SimpleClassBasedConstructorMock::class,
                                    $this->injector->inject(function (SimpleClassBasedConstructorMock $mock) {
                                        return $mock;
                                    }));
        }

        public function testInject_Inject_NotStatic()
        {
            $this->expectException(StaticCallNormalMethodException::class);
            $this->injector->inject([NonStaticInjectMock::class, 'notStatic']);
        }

        public function testInject_Inject_Static()
        {
            $this->assertNull($this->injector->inject([NonStaticInjectMock::class, 'static']));
        }
    }
