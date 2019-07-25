<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\DependencyInjection\Injector;

    class SimpleClassBasedConstructorMock
    {
        /** @var EmptyConstructorMock */
        public $empty;

        /** @var NoConstructorMock */
        public $no;

        /**
         * SimpleClassBasedConstructorMock constructor.
         *
         * @param EmptyConstructorMock $empty
         * @param NoConstructorMock    $no
         */
        public function __construct(EmptyConstructorMock $empty, NoConstructorMock $no)
        {
            $this->empty = $empty;
            $this->no = $no;
        }
    }
