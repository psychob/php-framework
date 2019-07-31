<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware\Executor;

    interface UseMiddlewareExecutorTag
    {
        public function setMiddlewareExecutor(MiddlewareExecutor $executor): void;
    }
