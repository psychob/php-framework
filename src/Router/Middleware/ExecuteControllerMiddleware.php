<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Router\Http\Response;
    use PsychoB\Framework\Router\MiddlewareExecutor;

    class ExecuteControllerMiddleware extends AbstractMiddleware
    {
        /** @var ResolverInterface */
        protected $resolver;

        /**
         * ExecuteControllerMiddleware constructor.
         *
         * @param ResolverInterface  $resolver
         * @param MiddlewareExecutor $executor
         */
        public function __construct(ResolverInterface $resolver, MiddlewareExecutor $executor)
        {
            $this->resolver = $resolver;

            parent::__construct($executor);
        }

        public function handle(Request $request, MiddlewareInterface $next): Response
        {
            dump($this);
        }

        public static function getPriority(): ?int
        {
            return PHP_INT_MAX;
        }
    }
