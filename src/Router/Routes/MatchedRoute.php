<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Routes;

    class MatchedRoute
    {
        /** @var Route */
        protected $route;

        /** @var mixed[] */
        protected $matchedArguments = [];

        /**
         * MatchedRoute constructor.
         *
         * @param Route   $route
         * @param mixed[] $matchedArguments
         */
        public function __construct(Route $route, array $matchedArguments)
        {
            $this->route = $route;
            $this->matchedArguments = $matchedArguments;
        }
    }
