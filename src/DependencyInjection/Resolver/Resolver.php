<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Resolver;

    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;

    class Resolver implements ResolverInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /** @var Injector */
        protected $injector;

        /**
         * Resolver constructor.
         *
         * @param ContainerInterface $container
         * @param Injector           $injector
         */
        public function __construct(ContainerInterface $container, Injector $injector)
        {
            $this->container = $container;
            $this->injector = $injector;
        }

        public function resolve(string $class, ?string $fromWhat)
        {
            return $this->injector->make($class);
        }
    }
