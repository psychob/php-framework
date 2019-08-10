<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template;

    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\Container\ReadOnlyContainerTrait;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;

    abstract class AbstractRepository
    {
        use ReadOnlyContainerTrait;

        /** @var ResolverInterface */
        protected $resolver;

        /**
         * TemplateBlockRepository constructor.
         *
         * @param ConfigManagerInterface $config
         * @param ResolverInterface      $resolver
         * @param string                 $configPath
         */
        public function __construct(ConfigManagerInterface $config, ResolverInterface $resolver, string $configPath)
        {
            $this->container = $config->get($configPath, []);
            $this->resolver = $resolver;
        }

        public function resolve(string $block, array $arguments = [])
        {
            return $this->resolver->resolve($this->get($block), $arguments);
        }
    }
