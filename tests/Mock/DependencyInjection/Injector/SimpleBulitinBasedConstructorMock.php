<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\DependencyInjection\Injector;

    class SimpleBulitinBasedConstructorMock
    {
        /** @var int */
        public $int;

        /** @var string */
        public $string;

        /**
         * SimpleBulitinBasedConstructorMock constructor.
         *
         * @param int    $int
         * @param string $string
         */
        public function __construct(int $int, string $string)
        {
            $this->int = $int;
            $this->string = $string;
        }
    }
