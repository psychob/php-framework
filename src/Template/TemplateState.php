<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template;

    use PsychoB\Framework\Container\ArrayAccessTrait;

    class TemplateState implements \ArrayAccess
    {
        use ArrayAccessTrait;

        /**
         * TemplateState constructor.
         *
         * @param array $container
         */
        public function __construct(array $container)
        {
            $this->container = $container;
        }
    }
