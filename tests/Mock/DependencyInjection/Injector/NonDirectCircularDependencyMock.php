<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\DependencyInjection\Injector;

    class NonDirectCircularDependencyMock
    {
        /** @var NonDirectCircularDependencyMock2 */
        protected $non;

        /**
         * NonDirectCircularDependencyMock2 constructor.
         *
         * @param NonDirectCircularDependencyMock2 $non
         */
        public function __construct(NonDirectCircularDependencyMock2 $non)
        {
            $this->non = $non;
        }

    }
