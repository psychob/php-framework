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
    use PsychoB\Framework\Template\Generic\BlockInterface;

    class TemplateBlockRepository
    {
        use ReadOnlyContainerTrait;

        /** @var ResolverInterface */
        protected $resolver;

        /**
         * TemplateBlockRepository constructor.
         *
         * @param ConfigManagerInterface $config
         * @param ResolverInterface      $resolver
         */
        public function __construct(ConfigManagerInterface $config, ResolverInterface $resolver)
        {
            $this->container = $config->get('template.blocks', []);
            $this->resolver = $resolver;
        }

        public function resolve(string $block, array $arguments = []): BlockInterface
        {
            return $this->resolver->resolve($this->get($block), $arguments);
        }
    }
