<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Config;

    use PsychoB\Framework\Config\ArrayConfigManager;

    class ArrayConfigManagerMock extends ArrayConfigManager
    {
        /**
         * ArrayConfigManagerMock constructor.
         *
         * @param array $container
         */
        public function __construct(array $container = [])
        {
            $this->container = $container;
        }
    }
