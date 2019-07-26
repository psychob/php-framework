<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router;

    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Router\Middleware\MiddlewareInterface;
    use PsychoB\Framework\Router\Middleware\NullMiddleware;
    use PsychoB\Framework\Utility\Arr;

    class MiddlewareExecutor
    {
        /** @var int */
        protected $count = 0;

        /** @var string[] */
        protected $middlewares = [];

        /** @var ResolverInterface */
        protected $resolver = NULL;

        /**
         * PassthroughsMiddleware constructor.
         *
         * @param string[]          $middleware
         * @param ResolverInterface $resolver
         */
        public function __construct(array $middleware, ResolverInterface $resolver)
        {
            $this->middlewares = $middleware;
            $this->resolver = $resolver;
        }

        public function handle($request, MiddlewareInterface $next)
        {
            return $next->handle($request, $this->next());
        }

        public function next(): MiddlewareInterface
        {
            if (Arr::has($this->middlewares, $this->count)) {
                $middle = $this->resolver->resolve($this->middlewares[$this->count]);

                if (method_exists($middle, 'setGlue')) {
                    $middle->setGlue($this);
                }

                $this->count++;
                return $middle;
            } else {
                return $this->resolver->resolve(NullMiddleware::class);
            }
        }
    }
