<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware\Executor;

    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Router\Middleware\ExecuteControllerMiddleware;
    use PsychoB\Framework\Router\Middleware\MiddlewareInterface;
    use PsychoB\Framework\Router\Middleware\NullMiddleware;
    use PsychoB\Framework\Router\Routes\MatchedRoute;
    use PsychoB\Framework\Router\Routes\Route;
    use PsychoB\Framework\Utility\Arr;

    class MiddlewareExecutor
    {
        /** @var int */
        protected $count = 0;

        /** @var string[] */
        protected $middlewares = [];

        /** @var ResolverInterface */
        protected $resolver = NULL;

        /**  @var Route|null */
        private $route;

        /**
         * PassthroughsMiddleware constructor.
         *
         * @param string[]          $middleware
         * @param MatchedRoute|null $route
         * @param ResolverInterface $resolver
         */
        public function __construct(array $middleware, ?MatchedRoute $route, ResolverInterface $resolver)
        {
            $this->middlewares = $middleware;
            $this->resolver = $resolver;
            $this->route = $route;
        }

        public function handle($request, MiddlewareInterface $next)
        {
            return $next->handle($request, $this->next());
        }

        public function next(): MiddlewareInterface
        {
            if (Arr::has($this->middlewares, $this->count)) {
                $middle = $this->resolver->resolve($this->middlewares[$this->count]);

                if ($middle instanceof UseMiddlewareExecutorTag) {
                    $middle->setMiddlewareExecutor($this);
                }

                if ($middle instanceof UseRouteInformationTag) {
                    if ($this->route) {
                        $middle->setRouteMatched($this->route);
                    }
                }

                $this->count++;

                return $middle;
            } else {
                return $this->resolver->resolve(NullMiddleware::class);
            }
        }
    }
