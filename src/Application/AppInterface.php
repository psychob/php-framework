<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application;

    interface AppInterface
    {
        public function setup(): void;

        public function handleWebRequest(string $method, string $uri);

        public function run();
    }
