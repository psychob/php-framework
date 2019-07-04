<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv\Sources;

    /**
     * @mix ValueParserTrait
     */
    trait FileLoaderTrait
    {
        protected static function loadFile(string $path): array
        {
            $ret = [];

            if (file_exists($path)) {
                foreach (file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
                    $hasComment = strpos($line, '#');
                    if ($hasComment !== false) {
                        $line = substr($line, 0, $hasComment - 1);
                    }

                    $assign = strpos($line, '=');
                    if ($assign === false) {
                        continue;
                    }

                    $key = substr($line, 0, $assign);
                    $value = substr($line, $assign + 1);

                    $ret[$key] = self::parseValue($value);
                }
            }

            return $ret;
        }
    }
