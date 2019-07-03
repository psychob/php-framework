<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\DotEnv;

    use PsychoB\Framework\DotEnv\DotEnvSourceInterface;
    use PsychoB\Framework\DotEnv\EnvSource;
    use PsychoB\Framework\DotEnv\EnvVarSource;
    use PsychoB\Framework\DotEnv\NonDirectEnvSource;
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
                [new EnvVarSource(true)],
                [new EnvSource('', '', true)],
                [new NonDirectEnvSource('', '', true, 'env')],
            ];
        }
    }
