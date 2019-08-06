<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Utility\StringManipulation;

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
            $this->assertSame($result, Str::findFirstNot($input, $toFind, $offset ?? 0));
        }
    }
