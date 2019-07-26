<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    class OptionsMiddleware extends AbstractMiddleware
    {
        public function handle($request, MiddlewareInterface $next)
        {
            return $next->handle($request, $this->next());
        }
    }
