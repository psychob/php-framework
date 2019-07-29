<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing\Traits;

    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;
    use PsychoB\Framework\DependencyInjection\Injector\InjectorInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\DeferredResolver;
    use PsychoB\Framework\DependencyInjection\Resolver\Resolver;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;

    trait EnableResolveInTestCaseTrait
    {
        /** @var ResolverInterface */
        private $__resolver;

        public function EnableResolveInTestCaseTrait_setUp()
        {
            $container = new Container();
            $deferred = new DeferredResolver();
            $injector = new Injector($container, $deferred);
            $config = \Mockery::mock(ConfigManagerInterface::class);

            $this->__resolver = new Resolver($container, $injector, $config);
            $deferred->setResolver($this->__resolver);

            $container->add(ContainerInterface::class, $container);
            $container->add(Container::class, $container);

            $container->add(ResolverInterface::class, $this->__resolver);
            $container->add(InjectorInterface::class, $injector);
            $container->add(Injector::class, $injector);
        }

        public function EnableResolveInTestCaseTrait_tearDown()
        {
            $this->__resolver = NULL;
        }

        protected function resolve(string $name, array $arguments = [])
        {
            return $this->__resolver->resolve($name, $arguments);
        }
    }
