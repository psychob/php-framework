<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http\Headers;

    interface HeaderInterface
    {
        public function __construct(string $header, string $value);

        public function getCanonicalName(): string;

        public function getOriginalName(): string;

        public function getOriginalValue(): string;
    }
