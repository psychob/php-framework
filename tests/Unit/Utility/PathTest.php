<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Utility;

    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Path;

    class PathTest extends UnitTestCase
    {
        /** @dataProvider provideJoin */
        public function testJoin(string $joined, string ...$paths)
        {
            $this->assertSame($joined, Path::join(...$paths));
        }

        public function provideJoin()
        {
            return [
                ['/home/psychob/Projekty/RGB Lighthouse/ja-app/public/..',
                    '/home/psychob/Projekty/RGB Lighthouse/ja-app/public', '..'],
                ['/home/psychob/Projekty/RGB Lighthouse/ja-app/public',
                    '/home/psychob/Projekty/RGB Lighthouse/ja-app/public'],
            ];
        }
    }
