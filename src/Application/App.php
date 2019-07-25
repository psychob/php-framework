<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application;

    use PsychoB\Framework\Commands\CommandManager;
    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;
    use PsychoB\Framework\DependencyInjection\Resolver\DeferredResolver;
    use PsychoB\Framework\DependencyInjection\Resolver\Resolver;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;

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

            // first we need to verify what kind of environment we are in, so we could create proper request,
            // and response
            if (php_sapi_name() === 'cli') {
                $this->handleCommand();
            } else {
                $this->handleWebRequest();
            }
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
            $this->container->add(ResolverInterface::class, $resolver);
        }

        public function resolve(string $class, array $arguments = [])
        {
            return $this->container->get(ResolverInterface::class)->resolve($class, $arguments);
        }

        public function basePath(): string
        {
            return $this->basePath;
        }

        protected function handleCommand()
        {
            /** @var CommandManager $commandManager */
            $commandManager = $this->resolve(CommandManager::class);
            $commandManager->run();
        }
    }
