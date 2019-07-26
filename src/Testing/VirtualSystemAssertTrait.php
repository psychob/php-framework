<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing;

    use org\bovigo\vfs\vfsStream;
    use org\bovigo\vfs\vfsStreamDirectory;
    use org\bovigo\vfs\vfsStreamFile;
    use PsychoB\Framework\Utility\Str;

    trait VirtualSystemAssertTrait
    {
        protected static function prepareVirtualFileSystem(array $fs): vfsStreamDirectory
        {
            $vfs = vfsStream::setup('/');

            foreach ($fs as $name => $content) {
                static::prepareVirtualFileSystemEntity($vfs, $name, $content);
            }

            return $vfs;
        }

        private static function prepareVirtualFileSystemEntity(vfsStreamDirectory $vfs, string $key, $content): void
        {
            if (is_array($content)) {
                $dir = static::prepareVirtualFileSystemDirectory($vfs, $key);

                foreach ($content as $name => $cont) {
                    static::prepareVirtualFileSystemEntity($dir, $name, $cont);
                }
            } else {
                $file = new vfsStreamFile($key);
                $file->at($vfs)->setContent($content);
            }
        }

        private static function prepareVirtualFileSystemDirectory(vfsStreamDirectory $vfs,
            string $name): vfsStreamDirectory
        {
            foreach (Str::explode($name, '/') as $dir) {
                $vfsDir = new vfsStreamDirectory($dir);
                $vfsDir->at($vfs);
                $vfs = $vfsDir;
            }

            return $vfs;
        }
    }
