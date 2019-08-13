<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Identity;

    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ValueIsNotTrueException extends AssertionException
    {
        public function __construct($value, ?string $customMessage = NULL, Throwable $previous = NULL)
        {
            parent::__construct($value,
                'is-true',
                sprintf('Value: %s doesnt equal true', Str::toRepr($value)),
                $customMessage,
                $previous);
        }
    }
