<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\EnumProperties;

    use Throwable;

    class ValueIsNotCombinationEnumException extends EnumAssertException
    {
        public function __construct($value,
            array $availableValues,
            ?string $message = NULL,
            ?Throwable $previous = NULL)
        {
            parent::__construct($value, $availableValues, 'enum-combination', 'one or combination of', $message, $previous);
        }
    }
