<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Validation\Asserts;

    use PsychoB\Framework\Testing\UnitTestCase;
    use PsychoB\Framework\Validation\Asserts\Exception\PropertyRequirementsAssert;
    use PsychoB\Framework\Validation\Asserts\PropertyRequirements;

    class PropertyRequirementsTest extends UnitTestCase
    {
        public function testValidate_Array_ExistingProperty()
        {
            $array = [
                'property' => 42,
            ];

            $this->assertTrue(PropertyRequirements::validate($array, [
                'property' => 42,
            ]));
        }

        public function testValidate_Array_ExistingProperty_InvalidValue()
        {
            $array = [
                'property' => 42,
            ];

            $this->assertFalse(PropertyRequirements::validate($array, [
                'property' => 84,
            ]));
        }

        public function testValidate_Array_NotExistingProperty()
        {
            $array = [
                'property' => 42,
            ];

            $this->assertFalse(PropertyRequirements::validate($array, [
                'privateProperty' => 42,
            ]));
        }

        public function testValidate_stdClass_ExistingProperty()
        {
            $std = new \stdClass();
            $std->property = 42;

            $this->assertTrue(PropertyRequirements::validate($std, [
                'property' => 42,
            ]));
        }

        public function testValidate_stdClass_ExistingProperty_InvalidValue()
        {
            $std = new \stdClass();
            $std->property = 42;

            $this->assertFalse(PropertyRequirements::validate($std, [
                'property' => 84,
            ]));
        }

        public function testValidate_stdClass_NotExistingProperty()
        {
            $std = new \stdClass();
            $std->property = 42;

            $this->assertFalse(PropertyRequirements::validate($std, [
                'privateProperty' => 42,
            ]));
        }

        public function testValidate_class_ExistingProperty()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->assertTrue(PropertyRequirements::validate($std, [
                'property' => 42,
            ]));
        }

        public function testValidate_class_ExistingProperty_InvalidValue()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->assertFalse(PropertyRequirements::validate($std, [
                'property' => 84,
            ]));
        }

        public function testValidate_cClass_Accessor()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->assertFalse(PropertyRequirements::validate($std, [
                'privateProperty' => 42,
            ]));
        }

        public function testValidate_cClass_PrivateProperty()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->assertFalse(PropertyRequirements::validate($std, [
                'anotherPrivateProperty' => 42,
            ]));
        }

        public function testEnsure_Array_ExistingProperty()
        {
            $array = [
                'property' => 42,
            ];

            PropertyRequirements::ensure($array, [
                'property' => 42,
            ]);
            $this->assertTrue(true);
        }

        public function testEnsure_Array_ExistingProperty_InvalidValue()
        {
            $array = [
                'property' => 42,
            ];

            $this->expectException(PropertyRequirementsAssert::class);
            PropertyRequirements::ensure($array, [
                'property' => 84,
            ]);
        }

        public function testEnsure_Array_NotExistingProperty()
        {
            $array = [
                'property' => 42,
            ];

            $this->expectException(PropertyRequirementsAssert::class);
            PropertyRequirements::ensure($array, [
                'privateProperty' => 42,
            ]);
        }

        public function testEnsure_stdClass_ExistingProperty()
        {
            $std = new \stdClass();
            $std->property = 42;

            PropertyRequirements::ensure($std, [
                'property' => 42,
            ]);
            $this->assertTrue(true);
        }

        public function testEnsure_stdClass_ExistingProperty_InvalidValue()
        {
            $std = new \stdClass();
            $std->property = 42;

            $this->expectException(PropertyRequirementsAssert::class);
            PropertyRequirements::ensure($std, [
                'property' => 84,
            ]);
        }

        public function testEnsure_stdClass_NotExistingProperty()
        {
            $std = new \stdClass();
            $std->property = 42;

            $this->expectException(PropertyRequirementsAssert::class);
            PropertyRequirements::ensure($std, [
                'privateProperty' => 42,
            ]);
        }

        public function testEnsure_class_ExistingProperty()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            PropertyRequirements::ensure($std, [
                'property' => 42,
            ]);
            $this->assertTrue(true);
        }

        public function testEnsure_class_ExistingProperty_InvalidValue()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->expectException(PropertyRequirementsAssert::class);
            PropertyRequirements::ensure($std, [
                'property' => 84,
            ]);
        }

        public function testEnsure_cClass_Accessor()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->expectException(PropertyRequirementsAssert::class);
            PropertyRequirements::ensure($std, [
                'privateProperty' => 42,
            ]);
        }

        public function testEnsure_cClass_PrivateProperty()
        {
            $std = new class
            {
                public $property = 42;
                private $privateProperty = 84;
                private $anotherPrivateProperty = 126;

                public function getPrivateProperty(): int
                {
                    return $this->privateProperty;
                }
            };

            $this->expectException(PropertyRequirementsAssert::class);
            PropertyRequirements::ensure($std, [
                'anotherPrivateProperty' => 42,
            ]);
        }
    }
