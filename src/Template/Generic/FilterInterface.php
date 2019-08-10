<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic;

    interface FilterInterface
    {
        public function supportsEmpty(): bool;

        public function executeEmpty(): array;

        public function execute($variable): array;
    }
