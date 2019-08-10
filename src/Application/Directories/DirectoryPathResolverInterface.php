<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application\Directories;

    interface DirectoryPathResolverInterface
    {
        public function resolvePath(string $path, string $subDir = ''): string;
    }
