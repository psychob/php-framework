<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class ValueIsEmptyException extends AssertionException
    {
        public function __construct($obj,
            ?string $message = NULL,
            Throwable $previous = NULL)
        {
            parent::__construct($obj, 'is-not-empty', 'Value is not empty', $message, $previous);
        }
    }
