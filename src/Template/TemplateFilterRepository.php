<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template;

    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;

    class TemplateFilterRepository extends AbstractRepository
    {
        public function __construct(ConfigManagerInterface $config, ResolverInterface $resolver)
        {
            parent::__construct($config, $resolver, 'template.filters');
        }
    }
