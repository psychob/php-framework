<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application;

    use PsychoB\Framework\Commands\CommandManager;
    use PsychoB\Framework\Config\ConfigManager;
    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;
    use PsychoB\Framework\DependencyInjection\Injector\InjectorInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\DeferredResolver;
    use PsychoB\Framework\DependencyInjection\Resolver\Resolver;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\FrameworkSource;
    use PsychoB\Framework\Router\RouteManager;
    use PsychoB\Framework\Template\TemplateFactory;
    use PsychoB\Framework\Template\TemplateResolveInterface;
    use PsychoB\Framework\Utility\Path;

    class App implements AppInterface,
                         Directories\DirectoryDiscoveryInterface,
                         Directories\DirectoryAdderInterface,
                         Directories\DirectoryPathResolverInterface
    {
        use Directories\DirectoryManagerTrait;

        /** @var ContainerInterface */
        protected $container;

        /**
         * App constructor.
         *
         * @param string $basePath
         */
        public function __construct(string $basePath)
        {
            $this->appBasePath = $basePath;
            $this->frameworkBasePath = Path::realpath(Path::join(FrameworkSource::CURRENT_DIR, '..'));
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
            $this->container->add(Directories\DirectoryDiscoveryInterface::class, $this);
            $this->container->add(Directories\DirectoryAdderInterface::class, $this);
            $this->container->add(Directories\DirectoryPathResolverInterface::class, $this);

            $this->setupResolver();
            $this->setupTemplate();
        }

        protected function setupResolver(): void
        {
            $config = new ConfigManager($this);

            $deferredResolver = new DeferredResolver();
            $injector = new Injector($this->container, $deferredResolver);
            $resolver = new Resolver($this->container, $injector, $config);
            $deferredResolver->setResolver($resolver);

            $this->container->add(Injector::class, $injector);
            $this->container->add(InjectorInterface::class, $injector);
            $this->container->add(Resolver::class, $resolver);
            $this->container->add(ResolverInterface::class, $resolver);
            $this->container->add(ConfigManager::class, $config);
            $this->container->add(ConfigManagerInterface::class, $config);
        }

        protected function setupTemplate(): void
        {
            $template = $this->resolve(TemplateFactory::class);
            $this->container->add(TemplateResolveInterface::class, $template);
        }

        public function resolve(string $class, array $arguments = [])
        {
            return $this->container->get(ResolverInterface::class)->resolve($class, $arguments);
        }

        protected function handleCommand()
        {
            /** @var CommandManager $commandManager */
            $commandManager = $this->resolve(CommandManager::class);
            $commandManager->run();
        }

        protected function handleWebRequest()
        {
            /** @var RouteManager $routeManager */
            $routeManager = $this->resolve(RouteManager::class);
            $routeManager->run();
        }
    }
