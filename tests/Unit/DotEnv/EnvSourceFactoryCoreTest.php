<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\DotEnv;

    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\EnvSourceFactory;
    use PsychoB\Framework\DotEnv\Sources\EnvVarSource;
    use PsychoB\Framework\Testing\UnitTestCase;

    class EnvSourceFactoryCoreTest extends UnitTestCase
    {
        public function testGetEnv()
        {
            $this->assertSame(DotEnv::ORDER_GETENV, EnvSourceFactory::getEnv());
            $this->assertSame(DotEnv::ORDER_GETENV, EnvSourceFactory::getEnv(true));

            $this->assertSame(['type' => DotEnv::ORDER_GETENV, 'volatile' => true], EnvSourceFactory::getEnv(false));
        }

        public function testDotEnv()
        {
            $this->assertSame(DotEnv::ORDER_DOT_ENV, EnvSourceFactory::dotEnv());

            $this->assertSame(['type' => DotEnv::ORDER_DOT_ENV, 'volatile' => true, 'file' => '.env'],
                              EnvSourceFactory::dotEnv(false));
            $this->assertSame(['type' => DotEnv::ORDER_DOT_ENV, 'volatile' => false, 'file' => '.my-config'],
                              EnvSourceFactory::dotEnv(true, '.my-config'));
        }

        public function testDotEnvDotEnv()
        {
            $this->assertSame(['type' => DotEnv::ORDER_DOT_ENV_ENVIRONMENT, 'volatile' => false, 'file' => '.env',
                               'env'  => 'APP_ENV'], EnvSourceFactory::dotEnvDotEnv('APP_ENV'));

            $this->assertSame(['type' => DotEnv::ORDER_DOT_ENV_ENVIRONMENT, 'volatile' => true, 'file' => '.my-config',
                               'env'  => 'APP_ENV'], EnvSourceFactory::dotEnvDotEnv('APP_ENV', false, '.my-config'));
        }

        public function testEnvVar()
        {
            $this->assertSame(DotEnv::ORDER_ENV_VAR, EnvSourceFactory::envVar());
            $this->assertSame(DotEnv::ORDER_ENV_VAR, EnvSourceFactory::envVar(true));

            $this->assertSame(['type' => DotEnv::ORDER_ENV_VAR, 'volatile' => true], EnvSourceFactory::envVar(false));
        }

        public function testCustom()
        {
            $dot = new EnvVarSource(false);

            $this->assertSame(['type' => DotEnv::ORDER_CUSTOM, 'bind' => $dot], EnvSourceFactory::custom($dot));
        }
    }
