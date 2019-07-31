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
    use PsychoB\Framework\Router\Middleware\Executor\MiddlewareExecutor;
    use PsychoB\Framework\Router\Middleware\MiddlewareInterface;
    use PsychoB\Framework\Router\Routes\MatchedRoute;
    use PsychoB\Framework\Router\Routes\Route;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class RouteManager
    {
        /** @var ResolverInterface */
        protected $resolver;

        /** @var MiddlewareInterface[] */
        protected $middlewares = [];

        /**  @var DirectoryDiscoveryInterface */
        protected $discovery;

        /** @var mixed[] */
        protected $routes = [];

        /** @var mixed[] */
        protected $middlewareAliases = [];

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
            $this->middlewareAliases = $config->get('routes.middlewares.aliases', []);
        }

        public function run()
        {
            $this->ensureRoutesAreLoaded();
            $request = $this->createRequestFromGlobal();

            $route = $this->findCorrectRoute($request);

            /** @var MiddlewareExecutor $passThrough */
            $passThrough = $this->resolver->resolve(MiddlewareExecutor::class, [$this->middlewares, $route]);
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
            $this->routes = Arr::appendValues($this->resolver->resolve(RouteFileParser::class)->parse($path),
                $this->routes);
        }

        protected function findCorrectRoute(Request $request): ?Route
        {
            foreach ($this->routes as $route) {
                if ($matchedRoute = $this->match($route, $request)) {
                    dump($matchedRoute);
                }
            }

            dump($request);

            return NULL;
        }

        protected function match(Route $route, Request $request): ?MatchedRoute
        {
            if (Arr::contains($route->getMethods(), $request->getMethod())) {
                $regExp = $this->generateRegexpFromUrl($route->getUrl());
            }

            return NULL;
        }

        private function generateRegexpFromUrl(string $getUrl): string
        {
            return '';
        }
    }

