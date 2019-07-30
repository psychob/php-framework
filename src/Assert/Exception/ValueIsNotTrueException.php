<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    class ValueIsNotTrueException extends AssertionException
    {
        public function __construct($value, ?string $message = NULL, \Throwable $previous = NULL)
        {
            parent::__construct($value, 'is-true', 'Value does not equal to true', $message, $previous);
        }
    }
