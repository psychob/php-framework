<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Equality;

    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ValueIsNotFalsyException extends AssertionException
    {
        public function __construct($obj,
            ?string $customMessage = NULL,
            Throwable $previous = NULL)
        {
            parent::__construct($obj,
                'is-falsy',
                sprintf('Value: %s is not falsy', Str::toRepr($obj)),
                $customMessage,
                $previous);
        }
    }
