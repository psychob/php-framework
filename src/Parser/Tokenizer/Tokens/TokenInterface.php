<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer\Tokens;

    interface TokenInterface
    {
        public function getToken(): string;

        public function getStart(): int;

        public function getEnd(): int;
    }
