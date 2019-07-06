<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DependencyInjection\Container;

    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Container\PsrAdapterContainer;
    use PsychoB\Framework\DependencyInjection\Exceptions\PsrContainerException;
    use PsychoB\Framework\DependencyInjection\Exceptions\PsrNotFoundException;
    use PsychoB\Framework\Testing\UnitTestCase;

    class PsrAdapterContainerTest extends UnitTestCase
    {
        /** @var PsrAdapterContainer */
        protected $adapter = NULL;

        protected function setUp(): void
        {
            parent::setUp();

            $container = \Mockery::mock(ContainerInterface::class);
            $this->adapter = new PsrAdapterContainer($container);

            $container->shouldReceive('has')->with(ContainerInterface::class)->andReturn(true);
            $container->shouldReceive('has')->with('FailureToRetrieve')->andReturn(true);
            $container->shouldReceive('has')->andReturn(false);
            $container->shouldReceive('get')->with(ContainerInterface::class)->andReturn($container);
        }

        public function testRetrieveSuccess()
        {
            $this->assertTrue($this->adapter->has(ContainerInterface::class));
            $this->assertInstanceOf(ContainerInterface::class, $this->adapter->get(ContainerInterface::class));
        }

        public function testRetrieveNotFound()
        {
            $this->assertFalse($this->adapter->has('NotFound'));
            $this->expectException(PsrNotFoundException::class);

            $this->adapter->get('NotFound');
        }

        public function testRetrieveFailure()
        {
            $this->assertTrue($this->adapter->has('FailureToRetrieve'));
            $this->expectException(PsrContainerException::class);

            $this->adapter->get('FailureToRetrieve');
        }
    }
