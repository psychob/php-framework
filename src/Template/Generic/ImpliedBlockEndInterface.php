<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic;

    interface ImpliedBlockEndInterface
    {
        /** @var int End of instruction is implied to be at end of instruction */
        public const IMPLIED_END_AT_INSTRUCTION = 1;

        /** @var int End of instruction is implied to be at end of block (when next block is closing, or when file ends) */
        public const IMPLIED_END_AT_BLOCK = 2;

        /**
         * Get implied end of block
         *
         * @return int
         */
        public static function metaGetImpliedEndOfBlock(): int;
    }
