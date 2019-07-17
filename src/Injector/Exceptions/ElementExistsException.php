<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Exceptions;

    use PsychoB\Framework\Core\Exceptions\Containers\ElementExistsException as CoreElementExistsException;
    use Throwable;

    class ElementExistsException extends CoreElementExistsException
    {
        public function __construct($key,
                                    $value,
                                    ?Throwable $previous = NULL)
        {
            parent::__construct($key, $value, 'Container already has this element', $previous);
        }
    }
