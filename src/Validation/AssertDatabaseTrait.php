<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation;

    trait AssertDatabaseTrait
    {
        protected static function get(string $name): string
        {
            return AssertDatabaseInstance::$Asserts[$name];
        }

        public function add(string $name, string $class)
        {
            AssertDatabaseInstance::addCustom($name, $class);
        }
    }
