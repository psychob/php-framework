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
    use PsychoB\Framework\Utility\Ref;

    trait EnableResolveInTestCaseTrait
    {
        /** @var ResolverInterface */
        private $_pbfw__resolver;

        public function EnableResolveInTestCaseTrait_setUp(): void
        {
            $container = new Container();
            $deferred = new DeferredResolver();
            $injector = new Injector($container, $deferred);

            if (Ref::hasTrait($this, EnableSeparateConfigurationInTestCaseTrait::class, true)) {
                $config = $this->_pbfw__config;
                $container->add(ConfigManagerInterface::class, $config, ContainerInterface::ADD_IGNORE);
            } else {
                $config = \Mockery::mock(ConfigManagerInterface::class);
            }

            $this->_pbfw__resolver = new Resolver($container, $injector, $config);
            $deferred->setResolver($this->_pbfw__resolver);

            $container->add(ContainerInterface::class, $container);
            $container->add(Container::class, $container);

            $container->add(ResolverInterface::class, $this->_pbfw__resolver);
            $container->add(InjectorInterface::class, $injector);
            $container->add(Injector::class, $injector);
        }

        public function EnableResolveInTestCaseTrait_tearDown(): void
        {
            $this->_pbfw__resolver = NULL;
        }

        public static function EnableResolveInTestCaseTrait_priority(): int
        {
            return 10;
        }

        protected function resolve(string $name, array $arguments = [])
        {
            return $this->_pbfw__resolver->resolve($name, $arguments);
        }
    }
