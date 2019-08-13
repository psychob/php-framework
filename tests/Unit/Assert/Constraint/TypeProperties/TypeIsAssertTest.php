<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Assert\Constraint\TypeProperties;

    use PsychoB\Framework\Assert\Constraints\TypeProperties\TypeIsAssert;
    use PsychoB\Framework\Testing\UnitTestCase;

    class TypeIsAssertTest extends UnitTestCase
    {
        public function provideTrueTestData(): array
        {
            return [
                [1, TypeIsAssert::TYPE_INT],
                [1.0, TypeIsAssert::TYPE_FLOAT],
                ["str", TypeIsAssert::TYPE_STRING],
                [["str"], TypeIsAssert::TYPE_ARRAY],
                [[], TypeIsAssert::TYPE_ARRAY],

                [1, [TypeIsAssert::TYPE_INT]],
                [false, [TypeIsAssert::TYPE_INT, TypeIsAssert::TYPE_BOOLEAN]],
            ];
        }

        public function provideFalseTestData(): array
        {
            return [
            ];
        }

        /** @dataProvider provideTrueTestData */
        public function testTrue($obj, $type): void
        {
            TypeIsAssert::ensure($obj, $type);
            $this->assertTrue(true);
        }
    }
