<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Exceptions;

    use Psr\Container\NotFoundExceptionInterface;
    use PsychoB\Framework\Core\Exceptions\Containers\ElementNotFoundException as CoreElementNotFoundException;
    use Throwable;

    class ElementNotFoundException extends CoreElementNotFoundException implements NotFoundExceptionInterface
    {
        public function __construct($key,
                                    array $array,
                                    Throwable $previous = NULL)
        {
            parent::__construct($key, $array, false, 'Class not found in container', $previous);
        }
    }
