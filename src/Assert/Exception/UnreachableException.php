<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class UnreachableException extends AssertionException
    {
        public function __construct(?string $customMessage = NULL,
            Throwable $previous = NULL)
        {
            parent::__construct(false,
                'unreachable',
                'This code was marked as unreachable, but it was reached!',
                $customMessage,
                $previous);
        }
    }
