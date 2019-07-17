<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Injector\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\Injector\Container\Container;
    use PsychoB\Framework\Injector\Container\ContainerInterface;
    use PsychoB\Framework\Injector\Exceptions\ElementExistsException;
    use PsychoB\Framework\Injector\Exceptions\ElementNotFoundException;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mocks\DependencyInjection\Injector\EmptyConstructorMock;

    class ContainerTest extends UnitTestCase
    {
        public function testHas()
        {
            $container = new Container();

            $this->assertTrue($container->has(Container::class));
            $this->assertTrue($container->has(ContainerInterface::class));
            $this->assertTrue($container->has(PsrContainerInterface::class));

            $this->assertFalse($container->has(EmptyConstructorMock::class));
        }

        public function testPsr()
        {
            $container = new Container();

            $this->assertInstanceOf(PsrContainerInterface::class, $container->psr());
            $this->assertInstanceOf(PsrContainerInterface::class, $container->get(PsrContainerInterface::class));
        }

        public function testAddOverride()
        {
            $container = new Container();

            $this->assertFalse($container->has(EmptyConstructorMock::class));

            $instances = [
                new EmptyConstructorMock(),
                new EmptyConstructorMock(),
            ];

            $container->add(EmptyConstructorMock::class, $instances[0], ContainerInterface::ADD_OVERRIDE);

            $this->assertTrue($container->has(EmptyConstructorMock::class));
            $this->assertSame($instances[0], $container->get(EmptyConstructorMock::class));

            $container->add(EmptyConstructorMock::class, $instances[1], ContainerInterface::ADD_OVERRIDE);

            $this->assertTrue($container->has(EmptyConstructorMock::class));
            $this->assertSame($instances[1], $container->get(EmptyConstructorMock::class));
        }

        public function testAddThrow()
        {
            $container = new Container();

            $this->assertFalse($container->has(EmptyConstructorMock::class));

            $instances = [
                new EmptyConstructorMock(),
                new EmptyConstructorMock(),
            ];

            $container->add(EmptyConstructorMock::class, $instances[0], ContainerInterface::ADD_THROW);

            $this->assertTrue($container->has(EmptyConstructorMock::class));
            $this->assertSame($instances[0], $container->get(EmptyConstructorMock::class));

            $this->expectException(ElementExistsException::class);
            $container->add(EmptyConstructorMock::class, $instances[1], ContainerInterface::ADD_THROW);
        }

        public function testGetNotExist()
        {
            $container = new Container();

            $this->expectException(ElementNotFoundException::class);
            $container->get(EmptyConstructorMock::class);
        }

        public function testResolve()
        {
            $this->markTestIncomplete();
        }
    }
