<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic;

    interface ArgumentHintInterface
    {
        public const ARG_OPTIONAL       = 0b0000000000;
        public const ARG_REQUIRED       = 0b0000000001;
        public const ARG_TYPE_PATH      = 0b0000000010;
        public const ARG_PATH_TEMPLATES = 0b1000000010;

        public static function getArguments(): array;
    }
