<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv\Sources;

    use org\bovigo\vfs\vfsStream;
    use org\bovigo\vfs\vfsStreamFile;
    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\Sources\DeferredDotEnvSource;
    use PsychoB\Framework\Exceptions\EntryNotFoundException;
    use PsychoB\Framework\Testing\TestCase;

    class DeferredDotEnvSourceTest extends TestCase
    {
        public function testLoadFileExist(): void
        {
            $dotEnv = new DotEnv('');
            $dotEnv->set('APP_ENV', 'production');

            $stream = vfsStream::setup('foo');
            $file = new vfsStreamFile('.env.production');
            $file->setContent(<<<CONFIG
FOO=BAR
CONFIG
            );
            $stream->addChild($file);

            $source = new DeferredDotEnvSource($stream->url(), '.env', 'APP_ENV', false, $dotEnv);

            $this->assertSame('BAR', $source->get('FOO'));
        }

        public function testLoadEntryNotExist(): void
        {
            $dotEnv = new DotEnv('');
            $dotEnv->set('APP_ENV', 'production');

            $stream = vfsStream::setup('foo');
            $file = new vfsStreamFile('.env.production');
            $stream->addChild($file);

            $source = new DeferredDotEnvSource($stream->url(), '.env', 'APP_ENV', false, $dotEnv);

            $this->expectException(EntryNotFoundException::class);
            $source->get('FOO');
        }

        public function testLoadEnvFileNotExists(): void
        {
            $dotEnv = new DotEnv('');
            $dotEnv->set('APP_ENV', 'production');

            $stream = vfsStream::setup('foo');
            $source = new DeferredDotEnvSource($stream->url(), '.env', 'APP_ENV', false, $dotEnv);

            $this->assertFalse($source->has('FOO'));

            $this->expectException(EntryNotFoundException::class);
            $source->get('FOO');
        }

        public function testLoadEnvEnvNotFound(): void
        {
            $dotEnv = new DotEnv('');

            $stream = vfsStream::setup('foo');
            $source = new DeferredDotEnvSource($stream->url(), '.env', 'APP_ENV', false, $dotEnv);

            $this->assertFalse($source->has('FOO'));

            $this->expectException(EntryNotFoundException::class);
            $source->get('FOO');
        }
    }