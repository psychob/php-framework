<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation;

    use PsychoB\Framework\Validation\Asserts\IsEqual;
    use PsychoB\Framework\Validation\Asserts\IsTrue;
    use PsychoB\Framework\Validation\Asserts\PropertyIsEqual;
    use PsychoB\Framework\Validation\Asserts\PropertyRequirements;

    class AssertDatabaseInstance
    {
        public static $Asserts = [
            'isEqual' => IsEqual::class,
            'isTrue' => IsTrue::class,
            'propIsEqual' => PropertyIsEqual::class,
            'propRequirements' => PropertyRequirements::class,
        ];

        public static function addCustom(string $name, string $validator): void
        {
            static::$Asserts[$name] = $validator;
        }
    }
