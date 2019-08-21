<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Other;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use Throwable;

    class UnreachableAssertException extends AssertionFailureException
    {
        public function __construct(
            ?string $customMessage = NULL,
            ?Throwable $previous = NULL)
        {
            parent::__construct('unreachable', 'This function should not be reached', $customMessage, -1, $previous);
        }
    }
