<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv\Exceptions;

    use PsychoB\Framework\Core\Exceptions\Containers\ElementNotFoundException;
    use Throwable;

    class EnvNotFoundException extends ElementNotFoundException
    {
        public function __construct($key, array $array = [], Throwable $previous = NULL)
        {
            parent::__construct($key, $array, false, 'Could not found element in environment', $previous);
        }
    }
