<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv;

    use Mockery\MockInterface;
    use org\bovigo\vfs\vfsStream;
    use org\bovigo\vfs\vfsStreamFile;
    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\EnvSourceFactory;
    use PsychoB\Framework\Testing\TestCase;

    class DotEnvTest extends TestCase
    {
        /** @var DotEnv|MockInterface */
        private $env;

        protected function setUp(): void
        {
            parent::setUp();

            $_ENV['APP_ENV'] = 'production';
            $_ENV['APP_FOO'] = 'bar';

            $baseDir = vfsStream::setup('configuration');
            $envFile = new vfsStreamFile('.env');
            $envFileDotEnv = new vfsStreamFile('.env.production');

            $envFile->setContent(<<<ENV_FILE
ENV_SPECIFIC=FOO
ENV_FILE
            );

            $envFileDotEnv->setContent(<<<ENV_FILE
ENV_DOT_ENV_SPECIFIC=BAR
ENV_FILE
            );

            $baseDir->addChild($envFile);
            $baseDir->addChild($envFileDotEnv);

            $this->env = new DotEnv(
                $baseDir->url(),
                EnvSourceFactory::envVar(),
                EnvSourceFactory::dotEnv(),
                EnvSourceFactory::dotEnvDotEnv('APP_ENV')
            );
        }

        public function testFetchFromEnv()
        {
            $this->assertSame('production', $this->env->get('APP_ENV'));
            $this->assertSame('bar', $this->env->get('APP_FOO'));
        }

        public function testFetchFromDotEnv()
        {
            $this->assertSame('production', $this->env->get('APP_ENV'));
            $this->assertSame('bar', $this->env->get('APP_FOO'));
            $this->assertSame('FOO', $this->env->get('ENV_SPECIFIC'));
        }

        public function testFetchFromDotEnvDotEnv()
        {
            $this->assertSame('production', $this->env->get('APP_ENV'));
            $this->assertSame('bar', $this->env->get('APP_FOO'));
            $this->assertSame('FOO', $this->env->get('ENV_SPECIFIC'));
            $this->assertSame('BAR', $this->env->get('ENV_DOT_ENV_SPECIFIC'));
        }
    }
