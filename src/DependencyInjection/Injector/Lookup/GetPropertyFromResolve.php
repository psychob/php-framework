<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector\Lookup;

    use PsychoB\Framework\DependencyInjection\Injector\InjectorInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;

    class GetPropertyFromResolve implements ArgumentLookupInterface
    {
        /** @var string */
        protected $class;

        /** @var string */
        protected $method;

        /**
         * GetPropertyFromResolve constructor.
         *
         * @param string $class
         * @param string $method
         */
        public function __construct(string $class, string $method)
        {
            $this->class = $class;
            $this->method = $method;
        }

        /** @inheritDoc */
        public function resolve(ResolverInterface $resolver)
        {
            $injector = $resolver->resolve(InjectorInterface::class);

            return $injector->inject([$resolver->resolve($this->class), $this->method]);
        }
    }
