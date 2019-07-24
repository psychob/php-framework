<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DependencyInjection\Container;

    use Mockery;
    use Mockery\MockInterface;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\NotFoundExceptionInterface;
    use PsychoB\Framework\DependencyInjection\Container\ContainerAdapter;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ErrorRetrievingElementException;
    use PsychoB\Framework\DependencyInjection\Container\Exception\PsrElementNotFoundException;
    use PsychoB\Framework\Testing\UnitTestCase;

    class ContainerAdapterTest extends UnitTestCase
    {
        /**
         * @var MockInterface|ContainerInterface
         */
        private $mock;

        protected function setUp(): void
        {
            parent::setUp();

            $this->mock = Mockery::mock(ContainerInterface::class);
            $this->mock->shouldReceive('has')->with('Exist')->andReturn(true);
            $this->mock->shouldReceive('has')->with('DosentExist')->andReturn(false);
            $this->mock->shouldReceive('has')->with('ErrorRetrival')->andReturn(true);

            $this->mock->shouldReceive('get')->with('Exist')->andReturn(true);
        }

        public function testHas()
        {
            $container = new ContainerAdapter($this->mock);

            $this->assertTrue($container->has('Exist'));
            $this->assertFalse($container->has('DosentExist'));
            $this->assertTrue($container->has('ErrorRetrival'));
        }

        public function testGetExist()
        {
            $container = new ContainerAdapter($this->mock);

            $this->assertSame(true, $container->get('Exist'));
        }

        public function testGetDosentExist()
        {
            $container = new ContainerAdapter($this->mock);

            $this->expectException(PsrElementNotFoundException::class);
            $this->assertSame(true, $container->get('DosentExist'));
        }

        public function testGetErrorRetrival()
        {
            $container = new ContainerAdapter($this->mock);

            $this->expectException(ErrorRetrievingElementException::class);
            $this->assertSame(true, $container->get('ErrorRetrival'));
        }

        public function testExceptionFromGetDosentExist()
        {
            $container = new ContainerAdapter($this->mock);
            $executed = false;

            try {
                $container->get('DosentExist');
            } catch (PsrElementNotFoundException $e) {
                $this->assertInstanceOf(NotFoundExceptionInterface::class, $e);
                $this->assertSame('DosentExist', $e->getKey());
                $executed = true;
            }

            $this->assertTrue($executed);
        }

        public function testExceptionGetErrorRetrival()
        {
            $container = new ContainerAdapter($this->mock);
            $executed = false;

            try {
                $container->get('ErrorRetrival');
            } catch (ErrorRetrievingElementException $e) {
                $this->assertInstanceOf(ContainerExceptionInterface::class, $e);
                $this->assertSame('ErrorRetrival', $e->getElement());
                $executed = true;
            }

            $this->assertTrue($executed);
        }
    }

