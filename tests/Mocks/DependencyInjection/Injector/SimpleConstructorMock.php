<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mocks\DependencyInjection\Injector;

    class SimpleConstructorMock
    {
        /** @var EmptyConstructorMock */
        public $emptyConstructor;

        /**
         * SimpleConstructorMock constructor.
         *
         * @param EmptyConstructorMock $emptyConstructor
         */
        public function __construct(EmptyConstructorMock $emptyConstructor)
        {
            $this->emptyConstructor = $emptyConstructor;
        }
    }
