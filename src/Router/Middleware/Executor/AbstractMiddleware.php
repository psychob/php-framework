<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware\Executor;

    use PsychoB\Framework\Router\Middleware\MiddlewareInterface;

    abstract class AbstractMiddleware implements MiddlewareInterface, UseMiddlewareExecutorTag
    {
        /** @var MiddlewareExecutor */
        protected $executor = NULL;

        public function setMiddlewareExecutor(MiddlewareExecutor $executor): void
        {
            $this->executor = $executor;
        }

        protected function next(): MiddlewareInterface
        {
            return $this->executor->next();
        }

        public static function getPriority(): ?int
        {
            return 10;
        }
    }
