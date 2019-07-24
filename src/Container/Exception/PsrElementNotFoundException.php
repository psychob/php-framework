<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Container\Exception;

    use Psr\Container\NotFoundExceptionInterface;
    use Throwable;

    class PsrElementNotFoundException extends ElementNotFoundException implements NotFoundExceptionInterface
    {
        public function __construct($key,
                                    string $message = '',
                                    ?Throwable $previous = NULL)
        {
            parent::__construct([], $key, false, $message, $previous);
        }
    }
