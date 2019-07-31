<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router;

    class Route
    {
        /** @var string */
        protected $name;

        /** @var string */
        protected $url;

        /** @var string[] */
        protected $methods = [];

        /** @var string[] */
        protected $middleware = [];

        /** @var string[] */
        protected $execute = [];

        /**
         * Route constructor.
         *
         * @param string   $name
         * @param string   $url
         * @param string[] $methods
         * @param string[] $middleware
         * @param string[] $execute
         */
        public function __construct(string $name, string $url, array $methods, array $middleware, array $execute)
        {
            $this->name = $name;
            $this->url = $url;
            $this->methods = $methods;
            $this->middleware = $middleware;
            $this->execute = $execute;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @return string
         */
        public function getUrl(): string
        {
            return $this->url;
        }

        /**
         * @return string[]
         */
        public function getMethods(): array
        {
            return $this->methods;
        }

        /**
         * @return string[]
         */
        public function getMiddleware(): array
        {
            return $this->middleware;
        }
    }
