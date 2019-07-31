<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Utility\StringManipulation;

    use PsychoB\Framework\Exception\InvalidArgumentException;
    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\StringManipulation\StrInfoTrait;

    class StrInfoTraitTest extends UnitTestCase
    {
        public function provideIs(): array
        {
            return [
                ['str', true],
                [true, false],
                [10, false],
                [new class
                {
                }, false],
            ];
        }

        /** @dataProvider provideIs */
        public function testIs($obj, bool $result): void
        {
            $this->assertSame($result, StrInfoTrait::is($obj));
        }

        public function provideLen(): array
        {
            return [
                ['', 0],
                ['s', 1],
                ['st', 2],
                ['str', 3],
            ];
        }

        /** @dataProvider provideLen */
        public function testLen(string $str, int $count): void
        {
            $this->assertSame($count, StrInfoTrait::len($str));
        }

        public function provideFirst(): array
        {
            return [
                ['a', 'a'],
                [' abcdefghijklmnoprstuwxyz', ' '],
                ['____', '_'],
            ];
        }

        /** @dataProvider provideFirst */
        public function testFirst(string $str, string $first): void
        {
            $this->assertSame($first, StrInfoTrait::first($str));
        }

        public function provideLast(): array
        {
            return [
                ['a', 'a'],
                [' abcdefghijklmnoprstuwxyz', 'z'],
                ['____', '_'],
            ];
        }

        /** @dataProvider provideLast */
        public function testLast(string $str, string $last): void
        {
            $this->assertSame($last, StrInfoTrait::last($str));
        }

        public function testFirst_failure(): void
        {
            $this->expectException(InvalidArgumentException::class);
            StrInfoTrait::first('');
        }

        public function testLast_failure(): void
        {
            $this->expectException(InvalidArgumentException::class);
            StrInfoTrait::last('');
        }

        public function provideTryFirst(): array
        {
            return [
                ['a', 'a'],
                [' abcdefghijklmnoprstuwxyz', ' '],
                ['____', '_'],
                ['', NULL],
            ];
        }

        /** @dataProvider provideTryFirst */
        public function testTryFirst(string $str, $first): void
        {
            $this->assertSame($first, StrInfoTrait::tryFirst($str));
        }

        public function provideTryLast(): array
        {
            return [
                ['a', 'a'],
                [' abcdefghijklmnoprstuwxyz', 'z'],
                ['____', '_'],
                ['', NULL],
            ];
        }

        /** @dataProvider provideTryLast */
        public function testTryLast(string $str, $last): void
        {
            $this->assertSame($last, StrInfoTrait::tryLast($str));
        }
    }
