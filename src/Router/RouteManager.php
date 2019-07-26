<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router;

    use PsychoB\Framework\Application\AppInterface;
    use PsychoB\Framework\Application\Directories\DirectoryDiscoveryInterface;
    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\CustomInjectionInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Lookup\GetPropertyFromResolve;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Router\Http\ParameterContainer;
    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Router\Http\RequestFactory;
    use PsychoB\Framework\Router\Middleware\MiddlewareInterface;

    class RouteManager
    {
        /** @var ResolverInterface */
        protected $resolver;

        /** @var MiddlewareInterface[] */
        protected $middlewares = [];

        /**  @var DirectoryDiscoveryInterface */
        protected $discovery;

        /**
         * RouteManager constructor.
         *
         * @param DirectoryDiscoveryInterface $discovery
         * @param ConfigManagerInterface      $config
         * @param ResolverInterface           $resolver
         */
        public function __construct(DirectoryDiscoveryInterface $discovery,
                                    ConfigManagerInterface $config,
                                    ResolverInterface $resolver)
        {
            $this->discovery = $discovery;
            $this->resolver = $resolver;
            $this->middlewares = $config->get('routes.middlewares.default', []);
        }

        public function run()
        {
            $this->ensureRoutesAreLoaded();
            $request = $this->createRequestFromGlobal();

            /** @var MiddlewareExecutor $passThrough */
            $passThrough = $this->resolver->resolve(MiddlewareExecutor::class, [$this->middlewares]);
            $response = $passThrough->handle($request, $passThrough->next());
        }

        private function createRequestFromGlobal()
        {
            return $this->resolver->resolve(RequestFactory::class)->fromGlobals();
        }

        private function ensureRoutesAreLoaded()
        {
            foreach ($this->discovery->fetchPathsFor('routes') as $paths) {
                $this->loadFile($paths);
            }
        }

        private function loadFile($path)
        {
            $content = $this->resolver->resolve(RouteFileParser::class)->parse($path);
            dump($content);
        }
    }

