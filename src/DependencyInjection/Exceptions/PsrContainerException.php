<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Exceptions;

    use Psr\Container\ContainerExceptionInterface;
    use PsychoB\Framework\Exceptions\EntryNotFoundException;

    /**
     * Exception that is thrown when there is error while retrieving element.
     *
     * This is done to have compatibility with psr/container interface.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class PsrContainerException extends EntryNotFoundException implements ContainerExceptionInterface
    {
        /// TODO: Should this exception inherits from EntryNotFound ?
    }
