<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application;

    class App implements AppInterface
    {
        /** @var string */
        protected $basePath;

        /**
         * App constructor.
         *
         * @param string $basePath
         */
        public function __construct(string $basePath)
        {
            $this->basePath = $basePath;
        }

        public function run()
        {
        }
    }
