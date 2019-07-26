<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    class ExecuteControllerMiddleware extends AbstractMiddleware
    {
        public function handle($request, MiddlewareInterface $next)
        {
            throw new \Exception();
        }

        public static function getPriority(): ?int
        {
            return PHP_INT_MAX;
        }
    }
