<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mocks\Injector\Injector;

    class AdvancedConstructorMock
    {
        /** @var EmptyConstructorMock */
        public $empty;

        /** @var NoConstructorMock */
        public $noConstructor;

        /** @var SimpleConstructorMock */
        public $simpleConstructor;

        /**
         * AdvancedConstructorMock constructor.
         *
         * @param EmptyConstructorMock  $empty
         * @param NoConstructorMock     $noConstructor
         * @param SimpleConstructorMock $simpleConstructor
         */
        public function __construct(EmptyConstructorMock $empty,
                                    NoConstructorMock $noConstructor,
                                    SimpleConstructorMock $simpleConstructor)
        {
            $this->empty = $empty;
            $this->noConstructor = $noConstructor;
            $this->simpleConstructor = $simpleConstructor;
        }
    }
