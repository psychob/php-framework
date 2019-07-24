<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DependencyInjection\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ElementAlreadyExistException;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ElementNotFoundException;
    use PsychoB\Framework\Testing\UnitTestCase;

    class ContainerTest extends UnitTestCase
    {
        public function testEmptyContainer()
        {
            $container = new Container();

            $this->assertTrue($container->has(Container::class));
            $this->assertTrue($container->has(ContainerInterface::class));
            $this->assertTrue($container->has(PsrContainerInterface::class));

            $this->assertSame($container, $container->get(Container::class));
            $this->assertSame($container, $container->get(ContainerInterface::class));
            $this->assertSame($container->psr(), $container->get(PsrContainerInterface::class));

            $this->assertInstanceOf(Container::class, $container->get(Container::class));
            $this->assertInstanceOf(ContainerInterface::class, $container->get(ContainerInterface::class));
            $this->assertInstanceOf(PsrContainerInterface::class, $container->get(PsrContainerInterface::class));
        }

        public function testGetElementThatExists()
        {
            $container = new Container();

            $this->assertSame($container, $container->get(Container::class));
            $this->assertSame($container, $container->get(ContainerInterface::class));
            $this->assertSame($container->psr(), $container->get(PsrContainerInterface::class));
        }

        public function testGetElementThatDosentExists()
        {
            $container = new Container();

            $this->expectException(ElementNotFoundException::class);
            $this->expectExceptionMessageRegExp('/' . preg_quote(static::class) . '/');

            $container->get(static::class);
        }

        public function testHas()
        {
            $container = new Container();

            $this->assertTrue($container->has(Container::class));
            $this->assertTrue($container->has(ContainerInterface::class));
            $this->assertTrue($container->has(PsrContainerInterface::class));
            $this->assertFalse($container->has(static::class));
        }

        public function testAddOverride()
        {
            $container = new Container();

            $this->assertFalse($container->has('Foo'));

            $container->add('Foo', 42, Container::ADD_OVERRIDE);
            $this->assertTrue($container->has('Foo'));
            $this->assertSame(42, $container->get('Foo'));

            $container->add('Foo', 84, Container::ADD_OVERRIDE);
            $this->assertTrue($container->has('Foo'));
            $this->assertSame(84, $container->get('Foo'));
        }

        public function testAddIgnore()
        {
            $container = new Container();

            $this->assertFalse($container->has('Foo'));

            $container->add('Foo', 42, Container::ADD_IGNORE);
            $this->assertTrue($container->has('Foo'));
            $this->assertSame(42, $container->get('Foo'));

            $container->add('Foo', 84, Container::ADD_IGNORE);
            $this->assertTrue($container->has('Foo'));
            $this->assertSame(42, $container->get('Foo'));
        }

        public function testAddThrow()
        {
            $container = new Container();

            $this->assertFalse($container->has('Foo'));

            $container->add('Foo', 42, Container::ADD_THROW);
            $this->assertTrue($container->has('Foo'));
            $this->assertSame(42, $container->get('Foo'));

            $this->expectException(ElementAlreadyExistException::class);
            $container->add('Foo', 84, Container::ADD_THROW);
        }

        public function testPsr()
        {
            $container = new Container();

            $this->assertInstanceOf(PsrContainerInterface::class, $container->psr());
        }
    }
