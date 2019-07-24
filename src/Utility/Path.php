<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    class Path
    {
        public static function realpath(string $path): string
        {
            return realpath($path);
        }

        public static function join(string ...$paths): string
        {
            return implode(DIRECTORY_SEPARATOR, $paths);
        }
    }
