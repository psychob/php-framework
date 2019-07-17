<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Injector\Container;

    use Mockery;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\NotFoundExceptionInterface;
    use PsychoB\Framework\Injector\Container\ContainerInterface;
    use PsychoB\Framework\Injector\Container\PsrContainerAdapter;
    use PsychoB\Framework\Testing\UnitTestCase;

    class PsrContainerAdapterTest extends UnitTestCase
    {
        /**
         * @var PsrContainerAdapter
         */
        private $adapter;

        protected function setUp(): void
        {
            parent::setUp();

            $mock = Mockery::mock(ContainerInterface::class);
            $mock->shouldReceive('has')->with('exists')->andReturn(true);
            $mock->shouldReceive('has')->with('cant retrive')->andReturn(true);
            $mock->shouldReceive('has')->with('dosent exists')->andReturn(false);

            $mock->shouldReceive('get')->with('exists')->andReturn(42);

            $this->adapter = new PsrContainerAdapter($mock);
        }

        public function testHas()
        {
            $this->assertTrue($this->adapter->has('exists'));
            $this->assertTrue($this->adapter->has('cant retrive'));
            $this->assertFalse($this->adapter->has('dosent exists'));
        }

        public function testFetchGood()
        {
            $this->assertSame(42, $this->adapter->get('exists'));
        }

        public function testFetchDosentExist()
        {
            $this->expectException(NotFoundExceptionInterface::class);

            $this->adapter->get('dosent exists');
        }

        public function testFetchCantRetrive()
        {
            $this->expectException(ContainerExceptionInterface::class);

            $this->adapter->get('cant retrive');
        }
    }
