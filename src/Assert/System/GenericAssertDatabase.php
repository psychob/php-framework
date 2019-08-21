<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\System;

    use PsychoB\Framework\Assert\Constraints\EnumProperties\ValidateEnumAssert;

    /**
     * Class that contains all default defined asserts
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    final class GenericAssertDatabase extends AssertDatabaseTrait
    {
        protected static $asserts = [
            'enumBits' => [ValidateEnumAssert::class, 'enumBits'],
            'enumArray' => [ValidateEnumAssert::class, 'enumArray'],
        ];
    }
