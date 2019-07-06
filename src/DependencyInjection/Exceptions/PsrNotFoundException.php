<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Exceptions;

    use Psr\Container\NotFoundExceptionInterface;
    use PsychoB\Framework\Exceptions\EntryNotFoundException;

    /**
     * Exception that is thrown when user is trying to retrieve value, that does not exist in container.
     *
     * This is done to have compatibility with psr/container interface.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class PsrNotFoundException extends EntryNotFoundException implements NotFoundExceptionInterface
    {
    }
