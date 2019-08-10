<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template;

    use PsychoB\Framework\Container\ArrayAccessTrait;
    use PsychoB\Framework\Template\Generic\FilterInterface;

    class TemplateState implements \ArrayAccess
    {
        use ArrayAccessTrait;

        /** @var TemplateFilterRepository */
        protected $filter;

        /**
         * TemplateState constructor.
         *
         * @param array                    $container
         * @param TemplateFilterRepository $filter
         */
        public function __construct(array $container, TemplateFilterRepository $filter)
        {
            $this->container = $container;
            $this->filter = $filter;
        }

        public function getFilter(string $filter): FilterInterface
        {
            return $this->filter->resolve($filter, []);
        }
    }
