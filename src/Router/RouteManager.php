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
    use PsychoB\Framework\Router\Routes\Loader\RouteFileLoader;
    use PsychoB\Framework\Router\Routes\MatchedRoute;
    use PsychoB\Framework\Router\Routes\Route;
    use PsychoB\Framework\Router\Routes\RouteMatcher;
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

            if ($route !== NULL) {
                $middlewares = $this->getMiddlewaresFor($route->getRoute());
            } else {
                $middlewares = $this->middlewares;
            }

            /** @var MiddlewareExecutor $passThrough */
            $passThrough = $this->resolver->resolve(MiddlewareExecutor::class, [$middlewares, $route]);
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
            $this->routes = Arr::appendValues($this->resolver->resolve(RouteFileLoader::class, [
                'path' => $path,
            ])->parse(), $this->routes);
        }

        private function findCorrectRoute(Request $request): ?MatchedRoute
        {
            foreach ($this->routes as $route) {
                if ($matched = $this->resolver->resolve(RouteMatcher::class, [$route])->isMatched($request)) {
                    return $matched;
                }
            }

            return NULL;
        }

        private function getMiddlewaresFor(Route $route): array
        {
            $middlewareClasses = $this->middlewares;

            foreach ($route->getMiddleware() as $middleware) {
                $middlewareClasses[] = $this->middlewareAliases[$middleware];
            }

            return Arr::sortByCustom($middlewareClasses, function ($el) {
                return call_user_func([$el, 'getPriority']);
            }, false);
        }
    }

