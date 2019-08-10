<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Container;

    use PsychoB\Framework\Container\CacheableIterator;
    use PsychoB\Framework\Testing\UnitTestCase;

    class CacheableIteratorTest extends UnitTestCase
    {
        public function testEmptyIterator()
        {
            $iterator = new CacheableIterator((function () {
                return;

                // we are forcing php to return Generator from this function, but because it's behind return, we will
                // never return an item from it
                yield;
            })());

            $this->assertArrayIsEmpty($iterator);
            $this->assertArrayIsEmpty($iterator);
            $this->assertArrayIsEmpty($iterator);
        }

        public function testMultipleItemsIterator()
        {
            $iterator = new CacheableIterator((function () {
                yield 1;
                yield 2;
                yield 3;
            })());

            $this->assertArrayElementsAre([1, 2, 3], $iterator, function ($e, $c, $ek) {
                $this->assertSame($e, $c, 'Bad element at: ' . $ek);
            });

            $this->assertArrayElementsAre([1, 2, 3], $iterator, function ($e, $c, $ek) {
                $this->assertSame($e, $c, 'Bad element at: ' . $ek);
            });

            $this->assertArrayElementsAre([1, 2, 3], $iterator, function ($e, $c, $ek) {
                $this->assertSame($e, $c, 'Bad element at: ' . $ek);
            });
        }

        public function testMultipleItemsIteratorRewindable()
        {
            $iterator = new CacheableIterator((function () {
                yield 1;
                yield 2;
                yield 3;
            })());

            $this->assertArrayElementsStartsWithValues([1], $iterator);
            $this->assertArrayElementsStartsWithValues([1, 2], $iterator);
            $this->assertArrayElementsStartsWithValues([1, 2, 3], $iterator);
        }

        public function testCurrentAfterIteratorCreation()
        {
            $iterator = new CacheableIterator((function () {
                yield 1;
                yield 2;
                yield 3;
            })());

            $this->assertSame(1, $iterator->current());
        }
    }
