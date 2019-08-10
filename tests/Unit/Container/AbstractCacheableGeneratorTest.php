<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Container;

    use Generator;
    use PsychoB\Framework\Container\AbstractCacheableGenerator;
    use PsychoB\Framework\Container\CacheableIterator;
    use PsychoB\Framework\Testing\UnitTestCase;

    class AbstractCacheableGeneratorTest extends UnitTestCase
    {
        public function testEmptyGenerator()
        {
            $generator = new class extends AbstractCacheableGenerator
            {
                protected function getGenerator(): Generator
                {
                    return;
                    yield 1;
                }
            };

            $this->assertArrayIsEmpty($generator);
            $this->assertArrayIsEmpty($generator);
            $this->assertArrayIsEmpty($generator);
        }

        public function testMultipleItemsGenerator()
        {
            $generator = new class extends AbstractCacheableGenerator
            {
                protected function getGenerator(): Generator
                {
                    yield 1;
                    yield 2;
                    yield 3;
                }
            };

            $this->assertArrayElementsAre([1, 2, 3], $generator, function ($e, $c, $ek) {
                $this->assertSame($e, $c, 'Bad element at: ' . $ek);
            });

            $this->assertArrayElementsAre([1, 2, 3], $generator, function ($e, $c, $ek) {
                $this->assertSame($e, $c, 'Bad element at: ' . $ek);
            });

            $this->assertArrayElementsAre([1, 2, 3], $generator, function ($e, $c, $ek) {
                $this->assertSame($e, $c, 'Bad element at: ' . $ek);
            });
        }

        public function testMultipleItemsIteratorRewindable()
        {
            $generator = new class extends AbstractCacheableGenerator
            {
                protected function getGenerator(): Generator
                {
                    yield 1;
                    yield 2;
                    yield 3;
                }
            };

            $this->assertArrayElementsStartsWithValues([1], $generator);
            $this->assertArrayElementsStartsWithValues([1, 2], $generator);
            $this->assertArrayElementsStartsWithValues([1, 2, 3], $generator);
        }
    }
