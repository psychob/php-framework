<?php
    //
    // psychob/ja
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //
    namespace PsychoB\Framework\Kernel\ErrorHandling;

    use Throwable;

    /**
     * Exception Handler Interface.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    interface ExceptionHandlerInterface
    {
        /**
         * This method reports $t
         *
         * @param Throwable $t
         */
        public function catchException(Throwable $t);
    }
