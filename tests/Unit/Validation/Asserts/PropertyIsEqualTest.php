<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Validation\Asserts;

    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Validation\Asserts\Exception\PropertyIsEqualAssert;
    use PsychoB\Framework\Validation\Asserts\PropertyIsEqual;

    class PropertyIsEqualTest extends UnitTestCase
    {
        public function testCanValidateStdObject()
        {
            $stdObj = new \stdClass();
            $stdObj->property = 42;

            $this->assertTrue(PropertyIsEqual::validate($stdObj, 'property', 42));
            $this->assertFalse(PropertyIsEqual::validate($stdObj, 'property', 84));
            $this->assertFalse(PropertyIsEqual::validate($stdObj, 'property_dosent_exists', 42));
        }

        public function testCanEnsureStdObject_Good()
        {
            $stdObj = new \stdClass();
            $stdObj->property = 42;

            PropertyIsEqual::ensure($stdObj, 'property', 42);
            $this->assertTrue(true);
        }

        public function testCanEnsureStdObject_Bad()
        {
            $stdObj = new \stdClass();
            $stdObj->property = 42;

            $this->expectException(PropertyIsEqualAssert::class);
            PropertyIsEqual::ensure($stdObj, 'privateProperty', 42);
        }

        public function testCanValidateArray()
        {
            $arr = [
                'exists' => true,
            ];

            $this->assertTrue(PropertyIsEqual::validate($arr, 'exists', true));
            $this->assertFalse(PropertyIsEqual::validate($arr, 'exists', false));
            $this->assertFalse(PropertyIsEqual::validate($arr, 'dosent-exists', false));
        }

        public function testCanEnsureArray_Good()
        {
            $arr = [
                'property' => 42,
            ];

            PropertyIsEqual::ensure($arr, 'property', 42);
            $this->assertTrue(true);
        }

        public function testCanEnsureArray_Bad()
        {
            $arr = [
                'property' => true,
            ];

            $this->expectException(PropertyIsEqualAssert::class);
            PropertyIsEqual::ensure($arr, 'privateProperty', 42);
        }

        public function testCanValidateObject()
        {
            $obj = new class
            {
                public $property = 42;
                private $privateProperty = 84;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->assertTrue(PropertyIsEqual::validate($obj, 'property', 42));
            $this->assertTrue(PropertyIsEqual::validate($obj, 'privateProperty', 84));
            $this->assertFalse(PropertyIsEqual::validate($obj, 'propertyThatDosentExist', 42));
        }

        public function testCanEnsureObject_PublicProperty()
        {
            $obj = new class
            {
                public $property = 42;
                private $privateProperty = 84;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            PropertyIsEqual::ensure($obj, 'property', 42);
            $this->assertTrue(true);
        }

        public function testCanEnsureObject_Accessor()
        {
            $obj = new class
            {
                public $property = 42;
                private $privateProperty = 84;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            PropertyIsEqual::ensure($obj, 'privateProperty', 84);
            $this->assertTrue(true);
        }

        public function testCanEnsureObject_Private()
        {
            $obj = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $fullPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->expectException(PropertyIsEqualAssert::class);
            PropertyIsEqual::ensure($obj, 'fullPrivateProperty', 126);
        }
    }
