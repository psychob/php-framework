<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Testing\ArrayAssertTrait;

    use ArrayIterator;
    use PHPUnit\Framework\AssertionFailedError;
    use PsychoB\Framework\Testing\ArrayAssertTrait;
    use PsychoB\Framework\Testing\UnitTestCase;

    class ArrayIsEmptyTest extends UnitTestCase
    {
        use ArrayAssertTrait;

        public function test_StandardArray_Empty()
        {
            $this->assertArrayIsEmpty([]);
        }

        public function test_Iterator_Empty()
        {
            $this->assertArrayIsEmpty(new ArrayIterator([]));
        }

        public function test_StandardArray_NotEmpty_NoMessage()
        {
            $this->expectException(AssertionFailedError::class);

            $this->assertArrayIsEmpty([1]);
        }

        public function test_Iterator_NotEmpty_NoMessage()
        {
            $this->expectException(AssertionFailedError::class);

            $this->assertArrayIsEmpty(new ArrayIterator([1]));
        }

        public function test_StandardArray_NotEmpty_Message()
        {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessageRegExp('/abcdefffefef/');

            $this->assertArrayIsEmpty([1], 'abcdefffefef');
        }

        public function test_Iterator_NotEmpty_Message()
        {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessageRegExp('/abcdefffefef/');

            $this->assertArrayIsEmpty(new ArrayIterator([1]), 'abcdefffefef');
        }

        public function test_Null_NoMessage()
        {
            $this->expectException(AssertionFailedError::class);

            $this->assertArrayIsEmpty(NULL);
        }

        public function test_Null_Message()
        {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessageRegExp('/abcdefffefef/');

            $this->assertArrayIsEmpty(NULL, 'abcdefffefef');
        }

        public function test_Unknown_NoMessage()
        {
            $this->expectException(AssertionFailedError::class);

            $this->assertArrayIsEmpty(new class { });
        }

        public function test_Unknown_Message()
        {
            $this->expectException(AssertionFailedError::class);
            $this->expectExceptionMessageRegExp('/abcdefffefef/');

            $this->assertArrayIsEmpty(new class { }, 'abcdefffefef');
        }
    }
