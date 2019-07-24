<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ElementNotFoundException;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ErrorRetrievingElementException;

    /**
     * Interface ContainerInterface.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    interface ContainerInterface
    {
        /** Add $object to container, and if older value exists - override it */
        public const ADD_OVERRIDE = 0;

        /** Add $object to container, and if older value exists - dont override it, ignore new one */
        public const ADD_IGNORE = 1;

        /** Add $object to container, and if older value exists - throw exception */
        public const ADD_THROW = 2;

        /**
         * Get $id from container.
         *
         * @param string $id
         *
         * @return mixed
         *
         * @throws ElementNotFoundException If element is not in container
         * @throws ErrorRetrievingElementException If there were error while retrieving element
         */
        public function get(string $id);

        /**
         * Check if container has element $id
         *
         * @param string $id
         *
         * @return bool
         */
        public function has(string $id): bool;

        /**
         * Add new element to container.
         *
         * @param string $id   Name of element
         * @param mixed  $obj  Value
         * @param int    $type One of ADD_OVERRIDE, ADD_IGNORE, ADD_THROW
         */
        public function add(string $id, $obj, int $type = self::ADD_OVERRIDE): void;

        /** Return psr/container compatible class */
        public function psr(): PsrContainerInterface;
    }
