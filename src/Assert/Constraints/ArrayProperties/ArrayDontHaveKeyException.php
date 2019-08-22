<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\ArrayProperties;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ArrayDontHaveKeyException extends ArrayAssertException
    {
        public function __construct($array, $key, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            parent::__construct($array, $key, 'has-key',
                sprintf('Array %s do not have key: %s', Str::toRepr($array), Str::toRepr($key)),
                $message, $previous);
        }
    }
