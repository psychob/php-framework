<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv;

    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\DotEnvSourceInterface;
    use PsychoB\Framework\DotEnv\Sources\CustomVarSource;
    use PsychoB\Framework\DotEnv\Sources\DeferredDotEnvSource;
    use PsychoB\Framework\DotEnv\Sources\DotEnvSource;
    use PsychoB\Framework\DotEnv\Sources\EnvVarSource;
    use PsychoB\Framework\DotEnv\Sources\GetEnvSource;
    use PsychoB\Framework\Testing\TestCase;

    class DotEnvSourceInterfaceTest extends TestCase
    {
        /** @dataProvider provideIsVolatile */
        public function testIsVolatile(DotEnvSourceInterface $source)
        {
            $this->assertTrue($source->isVolatile());
        }

        public function provideIsVolatile()
        {
            return [
                [new GetEnvSource(true)],
                [new DeferredDotEnvSource(NULL, '.env', 'APP_ENV', true, new DotEnv(''))],
                [new DotEnvSource(NULL, '.env', true)],
                [new EnvVarSource(true)],
                [new CustomVarSource(true, [])],
            ];
        }
    }
