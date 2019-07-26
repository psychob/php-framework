<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\DependencyInjection\Injector;

    class NonDirectCircularDependencyMock2
    {
        /** @var NonDirectCircularDependencyMock */
        protected $non;

        /**
         * NonDirectCircularDependencyMock2 constructor.
         *
         * @param NonDirectCircularDependencyMock $non
         */
        public function __construct(NonDirectCircularDependencyMock $non)
        {
            $this->non = $non;
        }

    }