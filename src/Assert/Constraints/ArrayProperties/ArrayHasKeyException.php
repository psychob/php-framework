<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\ArrayProperties;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ArrayHasKeyException extends ArrayAssertException
    {
        public function __construct($array, $key, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            parent::__construct($array, $key, 'dont-have-key',
                sprintf('Array %s have key: %s', Str::toRepr($array), Str::toRepr($key)),
                $message, $previous);
        }
    }
