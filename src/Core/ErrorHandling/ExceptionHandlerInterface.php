<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Core\ErrorHandling;

    use Throwable;

    interface ExceptionHandlerInterface
    {
        public function register(): void;

        public function handle(Throwable $t): void;
    }
