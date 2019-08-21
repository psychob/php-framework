<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Utility\StringManipulation;

    use PsychoB\Framework\Exception\InvalidArgumentException;
    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\Str;

    class StrFindTraitTest extends UnitTestCase
    {
        public function provideFindFirstNot()
        {
            return [
                ['aabbcc', 'ab', NULL, 4],
                ['aabbcc', 'abc', NULL, false],
                ['aabbcc', ['a', 'b'], NULL, 4],
                ['aabbcc', ['a', 'b', 'c'], NULL, false],
            ];
        }

        /** @dataProvider provideFindFirstNot */
        public function testFindFirstNot(string $input, $toFind, ?int $offset, $result): void
        {
            $this->assertSame($result, Str::findFirstNotOf($input, $toFind, $offset ?? 0));
        }

        public function provideFindFirstNotInvalidData(): array
        {
            return [
                ['abc', 1234, null],
                ['abc', 'ab', 40],
                ['abc', 'ab', -40],
            ];
        }

        /** @dataProvider provideFindFirstNotInvalidData */
        public function testFindFirstNotFailure(string $input, $toFind, ?int $offset): void
        {
            $this->expectException(InvalidArgumentException::class);

            Str::findFirstNotOf($input, $toFind, $offset ?? 0);
        }

        public function provideFindFirst()
        {
            return [
                ['aabbcc', 'ab', NULL, 0],
                ['aabbcc', 'abc', NULL, 0],
                ['aabbcc', ['a', 'b'], NULL, 0],
                ['aabbcc', ['a', 'b', 'c'], NULL, 0],
                ['aabbcc', 'c', NULL, 4],
                ['aabbcc', 'd', NULL, false],
                ['aabbcc', ['c', 'd'], NULL, 4],
                ['aabbcc', ['d', 'e', 'f'], NULL, false],
            ];
        }

        /** @dataProvider provideFindFirst */
        public function testFindFirst(string $input, $toFind, ?int $offset, $result): void
        {
            $this->assertSame($result, Str::findFirstOf($input, $toFind, $offset ?? 0));
        }
    }
