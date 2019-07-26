<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector\Lookup;

    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;

    class GetConfigValue implements ArgumentLookupInterface
    {
        /** @var string */
        protected $config;

        /**
         * GetConfigValue constructor.
         *
         * @param string $config
         */
        public function __construct(string $config)
        {
            $this->config = $config;
        }

        public function resolve(ResolverInterface $resolver)
        {
            return $resolver->resolve(ConfigManagerInterface::class)->get($this->config);
        }
    }
