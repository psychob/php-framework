<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Testing\Traits;

    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\Testing\Traits\EnableContainerInTestCaseTrait;
    use PsychoB\Framework\Testing\UnitTestCase;

    class EnableContainerInTestCaseTraitTest extends UnitTestCase
    {
        use EnableContainerInTestCaseTrait;

        public function test()
        {
            $this->assertInstanceOf(ContainerInterface::class, $this->getContainer());

            $container = new Container();
            $tmp = $this->swapContainer($container);
            $this->assertNotSame($tmp, $this->getContainer());
            $this->assertSame($container, $this->getContainer());
        }
    }
