<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use PsychoB\Framework\Exception\BaseElementNotFoundException;
    use Throwable;

    class AssertNotFoundException extends BaseElementNotFoundException
    {
        public function __construct($key,
            array $elements,
            string $message = '',
            ?Throwable $previous = NULL)
        {
            parent::__construct($elements, $key, false, $message, $previous);
        }
    }
