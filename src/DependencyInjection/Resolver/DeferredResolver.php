<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Resolver;

    class DeferredResolver implements ResolverInterface
    {
        /** @var ResolverInterface|null */
        protected $resolver;

        /**
         * DeferredResolver constructor.
         *
         * @param ResolverInterface $resolver
         */
        public function __construct(?ResolverInterface $resolver = NULL)
        {
            $this->resolver = $resolver;
        }

        /**
         * @return ResolverInterface|null
         */
        public function getResolver(): ?ResolverInterface
        {
            return $this->resolver;
        }

        /**
         * @param ResolverInterface|null $resolver
         */
        public function setResolver(?ResolverInterface $resolver): void
        {
            $this->resolver = $resolver;
        }

        public function resolve(string $class, array $arguments = [], ?string $fromWhat = NULL)
        {
            return $this->resolver->resolve($class, $arguments, $fromWhat);
        }
    }
