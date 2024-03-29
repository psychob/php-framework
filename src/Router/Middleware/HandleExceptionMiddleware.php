<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Router\Http\Response;
    use PsychoB\Framework\Router\Middleware\Executor\AbstractMiddleware;

    class HandleExceptionMiddleware extends AbstractMiddleware
    {
        public function handle(Request $request, MiddlewareInterface $next): Response
        {
            return $next->handle($request, $this->next());
        }

        public static function getPriority(): ?int
        {
            return PHP_INT_MIN;
        }
    }
