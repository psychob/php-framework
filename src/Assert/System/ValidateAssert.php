<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\System;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;

    final class ValidateAssert extends AssertDatabaseTrait
    {
        public static function __callStatic(string $name, $arguments)
        {
            try {
                parent::__callStatic($name, $arguments);
            } catch (AssertionFailureException $e) {
                return false;
            }

            return true;
        }
    }
