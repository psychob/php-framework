<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Resolver;

    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;

    class Resolver implements ResolverInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /** @var Injector */
        protected $injector;

        /** @var ConfigManagerInterface */
        protected $config;

        /**
         * Resolver constructor.
         *
         * @param ContainerInterface     $container
         * @param Injector               $injector
         * @param ConfigManagerInterface $config
         */
        public function __construct(ContainerInterface $container, Injector $injector, ConfigManagerInterface $config)
        {
            $this->container = $container;
            $this->injector = $injector;
            $this->config = $config;
        }

        public function resolve(string $class, array $arguments = [], ?string $fromWhat = NULL)
        {
            if ($this->container->has($class)) {
                return $this->container->get($class);
            }

            $obj = $this->injector->make($class, $arguments);
            $this->container->add($class, $obj);

            return $obj;
        }
    }
