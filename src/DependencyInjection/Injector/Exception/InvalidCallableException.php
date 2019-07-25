<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector\Exception;

    use PsychoB\Framework\Exception\BaseInvalidArgumentException;

    class InvalidCallableException extends BaseInvalidArgumentException
    {
        public static function invalidArrayFormat(array $callable): self
        {
            return new InvalidCallableException();
        }

        public static function invalidCallable($callable)
        {
            return new InvalidCallableException();
        }
    }

