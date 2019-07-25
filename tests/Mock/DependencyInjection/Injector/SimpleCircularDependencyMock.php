<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\DependencyInjection\Injector;

    class SimpleCircularDependencyMock
    {
        /** @var SimpleCircularDependencyMock */
        public $circular;

        /**
         * SimpleCircularDependencyMock constructor.
         *
         * @param SimpleCircularDependencyMock $circular
         */
        public function __construct(SimpleCircularDependencyMock $circular)
        {
            $this->circular = $circular;
        }
    }
