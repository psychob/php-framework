<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware\Executor;

    use PsychoB\Framework\Router\Routes\MatchedRoute;

    interface UseRouteInformationTag
    {
        public function setRouteMatched(MatchedRoute $route): void;
    }
