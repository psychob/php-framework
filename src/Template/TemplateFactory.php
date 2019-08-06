<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template;

    use PsychoB\Framework\Application\Directories\DirectoryPathResolverInterface;
    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Template\Engine\TemplateEngineInterface;
    use PsychoB\Framework\Utility\Path;

    class TemplateFactory implements TemplateResolveInterface
    {
        /** @var DirectoryPathResolverInterface */
        protected $pathResolver;

        /** @var ResolverInterface */
        protected $classResolver;

        /** @var mixed[] */
        protected $engines = [];

        /**
         * TemplateFactory constructor.
         *
         * @param DirectoryPathResolverInterface $resolver
         * @param ConfigManagerInterface         $config
         * @param ResolverInterface              $classResolver
         */
        public function __construct(DirectoryPathResolverInterface $resolver,
            ConfigManagerInterface $config,
            ResolverInterface $classResolver)
        {
            $this->pathResolver = $resolver;
            $this->engines = $config->get('template.engines');
            $this->classResolver = $classResolver;
        }

        public function render(string $template, array $variables = []): string
        {
            $realPath = $this->pathResolver->resolvePath($template, 'resources/views');
            $engineClass = $this->engines[Path::getExtension($realPath)];

            /** @var TemplateEngineInterface $engine */
            $engine = $this->classResolver->resolve($engineClass);

            /// TODO: add cache
            return $engine->execute(file_get_contents($realPath), $variables);
        }
    }
