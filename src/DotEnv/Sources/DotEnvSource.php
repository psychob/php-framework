<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv\Sources;

    class DotEnvSource extends CustomVarSource
    {
        use FileLoaderTrait;

        public function __construct(?string $basePath, string $file, bool $isVolatile)
        {
            $path = $file;

            if ($basePath !== null) {
                $path = $basePath . DIRECTORY_SEPARATOR . $path;
            }

            parent::__construct($isVolatile, self::loadFile($path));
        }
    }
