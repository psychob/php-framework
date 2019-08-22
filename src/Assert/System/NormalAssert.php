<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\System;

    use PsychoB\Framework\Assert\Constraints\Other\UnreachableAssert;

    final class NormalAssert extends AssertDatabaseTrait
    {
        protected static $asserts = [
            'unreachable' => [UnreachableAssert::class, 'ensure'],
        ];
    }
