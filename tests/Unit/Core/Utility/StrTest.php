<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Core\Utility;

    use Closure;
    use Generator;
    use PsychoB\Framework\Core\Utility\Str;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mocks\Core\Utility\Str\GeneratorMock;
    use Tests\PsychoB\Framework\Mocks\Core\Utility\Str\ToStringMock;

    class StrTest extends UnitTestCase
    {
        public function provideToStr(): array
        {
            return [
                [null, ''],
                [42, '42'],
                [42.42, '42.42'],
                [new ToStringMock(), '68'],
            ];
        }

        /** @dataProvider provideToStr */
        public function testToStr($obj, string $strObj): void
        {
            $this->assertSame($strObj, Str::toStr($obj));
        }

        public function provideToType(): array
        {
            return [
                [null, 'null'],
                ['string', 'string'],
                [[], 'array'],
                [GeneratorMock::get(), Generator::class],
                [function () { }, Closure::class],
                [42, 'integer'],
                [42.42, 'double'],
                [$this, StrTest::class],
            ];
        }

        /** @dataProvider provideToType */
        public function testToType($obj, string $strObj): void
        {
            $this->assertSame($strObj, Str::toType($obj));
        }
    }
