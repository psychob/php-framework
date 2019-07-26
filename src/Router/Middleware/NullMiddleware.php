<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    use PsychoB\Framework\Router\Exception\NullMiddlewareReachedException;
    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Router\Http\Response;

    class NullMiddleware implements MiddlewareInterface
    {
        public function handle(Request $request, MiddlewareInterface $next): Response
        {
            throw new NullMiddlewareReachedException();
        }

        public function next(): MiddlewareInterface
        {
            return $this;
        }

        public static function getPriority(): ?int
        {
            return PHP_INT_MIN;
        }
    }
