<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application\Directories;

    interface DirectoryDiscoveryInterface
    {
        public function getBaseDirectories(): array;

        public function getFrameworkDirectory(): string;

        public function getApplicationDirectory(): string;

        public function fetchPathsFor(string $module, ?string $subPath = null): array;
    }
