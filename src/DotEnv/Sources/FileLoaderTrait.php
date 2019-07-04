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
                    //
                    // We assume line contains comment if:
                    // - Line starts with #
                    // - Line contains sequence: SPACE HASH ( #)
                    //
                    // Second option is for lines that contains hash in url, so we won't pick up those as comments
                    //
                    $hasComment = strpos($line, '#');
                    if ($hasComment !== false) {
                        if ($hasComment === 0) {
                            continue;
                        } else if ($line[$hasComment - 1] === ' ') {
                            $line = substr($line, 0, $hasComment - 1);
                        }
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
