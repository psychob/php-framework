<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Router\Http\Response;

    interface MiddlewareInterface
    {
        public function handle(Request $request, MiddlewareInterface $next): Response;

        public static function getPriority(): ?int;
    }
