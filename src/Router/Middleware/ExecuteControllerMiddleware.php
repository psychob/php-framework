<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\DependencyInjection\Injector\InjectorInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Router\Http\Response;
    use PsychoB\Framework\Router\Http\ResponseFailures\Http404;
    use PsychoB\Framework\Router\Middleware\Executor\AbstractMiddleware;
    use PsychoB\Framework\Router\Middleware\Executor\MiddlewareExecutor;
    use PsychoB\Framework\Router\Middleware\Executor\UseRouteInformationTag;
    use PsychoB\Framework\Router\Routes\MatchedRoute;
    use PsychoB\Framework\Router\Routes\Route;

    class ExecuteControllerMiddleware extends AbstractMiddleware implements UseRouteInformationTag
    {
        /** @var ResolverInterface */
        protected $resolver;

        /** @var MatchedRoute|null */
        protected $route = NULL;

        /**
         * ExecuteControllerMiddleware constructor.
         *
         * @param ResolverInterface $resolver
         */
        public function __construct(ResolverInterface $resolver)
        {
            $this->resolver = $resolver;
        }

        public function handle(Request $request, MiddlewareInterface $next): Response
        {
            if ($this->route === NULL) {
                // in this case, we can't do anything about it but throw 404 error
                throw new Http404($request);
            }

            $view = $this->route->getRoute()->getView();
            $execute = $this->route->getRoute()->getExecute();

            if ($execute) {
                $response = NULL;
                $injector = $this->resolver->resolve(InjectorInterface::class);

                switch ($execute[1]) {
                    case '::':
                        $response = $injector->inject([$execute[1], $execute[2]]);
                        break;

                    case '->':
                        $class = $this->resolver->resolve($execute[0]);
                        $response = $injector->inject([$class, $execute[2]]);
                        break;

                    default:
                        Assert::unreachable();
                }

                return $response;
            }

            dump($this);
        }

        public static function getPriority(): ?int
        {
            return PHP_INT_MAX;
        }

        public function setRouteMatched(MatchedRoute $route): void
        {
            $this->route = $route;
        }
    }
