<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Middleware;

    use PsychoB\Framework\Router\MiddlewareExecutor;

    abstract class AbstractMiddleware implements MiddlewareInterface
    {
        /** @var MiddlewareExecutor */
        protected $executor = NULL;

        /**
         * AbstractMiddleware constructor.
         *
         * @param MiddlewareExecutor $executor
         */
        public function __construct(MiddlewareExecutor $executor)
        {
            $this->executor = $executor;
        }

        protected function next(): MiddlewareInterface
        {
            return $this->executor->next();
        }

        public static function getPriority(): ?int
        {
            return null;
        }
    }
