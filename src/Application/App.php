<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application;

    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;
    use PsychoB\Framework\DependencyInjection\Resolver\DeferredResolver;
    use PsychoB\Framework\DependencyInjection\Resolver\Resolver;

    class App implements AppInterface
    {
        /** @var string */
        protected $basePath;

        /** @var ContainerInterface */
        protected $container;

        /**
         * App constructor.
         *
         * @param string $basePath
         */
        public function __construct(string $basePath)
        {
            $this->basePath = $basePath;
        }

        public function run()
        {
            $this->setup();
        }

        public function setup(): void
        {
            $this->container = new Container();
            $this->container->add(App::class, $this);
            $this->container->add(AppInterface::class, $this);

            $deferredResolver = new DeferredResolver();
            $injector = new Injector($this->container, $deferredResolver);
            $resolver = new Resolver($this->container, $injector);
            $deferredResolver->setResolver($resolver);

            $this->container->add(Injector::class, $injector);
            $this->container->add(Resolver::class, $resolver);
        }

        public function handleWebRequest(string $method, string $uri)
        {
            // TODO: Implement handleWebRequest() method.
        }
    }
