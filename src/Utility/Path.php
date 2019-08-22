<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Utility;

    use PsychoB\Framework\Assert\Assert;

    class Path
    {
        public static function realpath(string $path): string
        {
            return realpath($path);
        }

        public static function join(string ...$paths): string
        {
            Assert::arguments()->notEmpty($paths);

            switch (Arr::len($paths)) {
                case 1:
                    return $paths[0];

                default:
                    $ret = $paths[0];

                    foreach (Arr::slice($paths, 1) as $value) {
                        if (Str::last($ret) === DIRECTORY_SEPARATOR &&
                            Str::first($value) === DIRECTORY_SEPARATOR) {
                            $ret .= Str::substr($value, 1);
                        } else if (Str::last($ret) !== DIRECTORY_SEPARATOR &&
                            Str::first($value) !== DIRECTORY_SEPARATOR) {
                            $ret .= DIRECTORY_SEPARATOR . $value;
                        } else {
                            $ret .= $value;
                        }
                    }

                    return $ret;
            }
        }

        public static function fileExists(string $path): bool
        {
            return file_exists($path);
        }

        public static function getExtension(string $path): string
        {
            return pathinfo($path, PATHINFO_EXTENSION);
        }
    }
