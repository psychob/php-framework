<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Utility\StringManipulation;

    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Utility\StringManipulation\StrCompareTrait;

    class StrCompareTraitTest extends UnitTestCase
    {
        public function provideCompare(): array
        {
            // @formatter:off
            return [
                ['left'     , 'right'   , NULL  , NULL  , NULL  , true  , -1],
                ['left'     , 'right'   , NULL  , NULL  , NULL  , false , -1],
                ['left'     , 'LEFT'    , NULL  , NULL  , NULL  , true  ,  1],
                ['left'     , 'LEFT'    , NULL  , NULL  , NULL  , false ,  0],
                ['left'     , 'LefT'    , 2     , 1     , 1     , true  ,  0],
                ['RefG'     , 'LEFT'    , 2     , 1     , 1     , false ,  0],
                ['left'     , 'LeFT'    , 2     , 1     , 1     , true  ,  1],
                ['RefG'     , 'LEGT'    , 2     , 1     , 1     , false , -1],
                ['left'     , 'Le'      , 2     , 1     , 1     , true  ,  1],
                ['Re'       , 'LEGT'    , 2     , 1     , 1     , false , -1],
                ['FooBar'   , 'Bar'     , NULL  , 3     , NULL  , true  ,  0],
                ['FooBAR'   , 'Bar'     , NULL  , 3     , NULL  , false ,  0],
                ['FooBar'   , 'Ba'      , NULL  , 3     , NULL  , true  ,  1],
                ['FooBizanc', 'Bar'     , NULL  , 3     , NULL  , false ,  1],
                ['FooBar'   , 'FooBaz'  , 3     , NULL  , NULL  , true  ,  0],
                ['FOOBAR'   , 'fooyar'  , 3     , NULL  , NULL  , false ,  0],
            ];
            // @formatter:on
        }

        /** @dataProvider provideCompare */
        public function testCompare(string $left,
            string $right,
            ?int $length,
            ?int $leftStart,
            ?int $rightStart,
            bool $cs,
            $ret)
        {
            if ($ret === 0) {
                $this->assertSame(0, StrCompareTrait::compare($left, $right, $length, $leftStart, $rightStart, $cs));
            } else if ($ret > 0) {
                $this->assertGreaterThan(0,
                    StrCompareTrait::compare($left, $right, $length, $leftStart, $rightStart, $cs));
            } else if ($ret < 0) {
                $this->assertLessThan(0,
                    StrCompareTrait::compare($left, $right, $length, $leftStart, $rightStart, $cs));
            }
        }

        public function provideEquals(): array
        {
            // @formatter:off
            return [
                ['left'     , 'right'   , NULL  , NULL  , NULL  , true  , false],
                ['left'     , 'right'   , NULL  , NULL  , NULL  , false , false],
                ['left'     , 'LEFT'    , NULL  , NULL  , NULL  , true  , false],
                ['left'     , 'LEFT'    , NULL  , NULL  , NULL  , false , true],
                ['left'     , 'LefT'    , 2     , 1     , 1     , true  , true],
                ['RefG'     , 'LEFT'    , 2     , 1     , 1     , false , true],
                ['left'     , 'LeFT'    , 2     , 1     , 1     , true  , false],
                ['RefG'     , 'LEGT'    , 2     , 1     , 1     , false , false],
                ['left'     , 'Le'      , 2     , 1     , 1     , true  , false],
                ['Re'       , 'LEGT'    , 2     , 1     , 1     , false , false],
                ['FooBar'   , 'Bar'     , NULL  , 3     , NULL  , true  , true],
                ['FooBAR'   , 'Bar'     , NULL  , 3     , NULL  , false , true],
                ['FooBar'   , 'Ba'      , NULL  , 3     , NULL  , true  , false],
                ['FooBizanc', 'Bar'     , NULL  , 3     , NULL  , false , false],
                ['FooBar'   , 'FooBaz'  , 3     , NULL  , NULL  , true  , true],
                ['FOOBAR'   , 'fooyar'  , 3     , NULL  , NULL  , false , true],
            ];
            // @formatter:on
        }

        /** @dataProvider provideEquals */
        public function testEquals(string $left,
            string $right,
            ?int $length,
            ?int $leftStart,
            ?int $rightStart,
            bool $cs,
            bool $ret)
        {
            $this->assertSame($ret, StrCompareTrait::equals($left, $right, $length, $leftStart, $rightStart, $cs));
        }
    }
