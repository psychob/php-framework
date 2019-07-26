<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router;

    use PsychoB\Framework\Application\AppInterface;
    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\CustomInjectionInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Lookup\GetPropertyFromResolve;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Router\Middleware\MiddlewareInterface;

    class RouteManager implements CustomInjectionInterface
    {
        /** @var ResolverInterface */
        protected $resolver;

        /** @var MiddlewareInterface[] */
        protected $middlewares = [];

        public static function __pbfw_injectHint(): array
        {
            return [
                '__construct' => [
                    'basePath' => new GetPropertyFromResolve(AppInterface::class, 'getBasePath'),
                ],
            ];
        }

        /**
         * RouteManager constructor.
         *
         * @param string                 $basePath
         * @param ConfigManagerInterface $config
         * @param ResolverInterface      $resolver
         */
        public function __construct(string $basePath, ConfigManagerInterface $config, ResolverInterface $resolver)
        {
            $this->resolver = $resolver;
            $this->middlewares = $config->get('routes.middlewares.default', []);
        }

        public function run()
        {
            $request = $this->createRequestFromGlobal();

            /** @var MiddlewareExecutor $passThrough */
            $passThrough = $this->resolver->resolve(MiddlewareExecutor::class, [$this->middlewares]);
            $response = $passThrough->handle($request, $passThrough->next());
        }

        private function createRequestFromGlobal()
        {
            return Request::createFromGlobals();
        }
    }

