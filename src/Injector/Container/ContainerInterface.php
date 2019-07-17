<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\Injector\Exceptions\CanNotRetrieveElementException;
    use PsychoB\Framework\Injector\Exceptions\ElementExistsException;
    use PsychoB\Framework\Injector\Exceptions\ElementNotFoundException;

    /**
     * Interface ContainerInterface.
     *
     * Container used to hold all defined classes.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    interface ContainerInterface
    {
        /**
         * When adding new $class into container, override old value if exist
         */
        public const ADD_OVERRIDE = 0;

        /**
         * When adding new $class into container, throw exception if old value exists
         */
        public const ADD_THROW = 1;

        /**
         * When resolving $class, always add it inside container.
         */
        public const RESOLVE_ADD = 0x0001;

        /**
         * When resolving $class, check typehints to verify if class should be added into container, or should be
         * ignored.
         *
         * When combined with ContainerInterface::RESOLVE_ADD, all classes that dosen't have typehint will be added.
         *
         * When combined with ContainerInterface::RESOLVE_IGNORE, all classes that dosen't have typehint will be
         * ignored. This is default behaviour.
         */
        public const RESOLVE_TYPEHINT = 0x0002;

        /**
         * When resolving $class, never add it to container.
         */
        public const RESOLVE_IGNORE = 0x0004;

        /**
         * Check if $class exists in container.
         *
         * @param string $class Class to check
         *
         * @return bool
         */
        public function has(string $class): bool;

        /**
         * Retrieve $class from container.
         *
         * @param string $class
         *
         * @return mixed
         *
         * @throws CanNotRetrieveElementException When there was problem with retrieving class.
         * @throws ElementNotFoundException When $class did not exist in this container.
         */
        public function get(string $class);

        /**
         * Add $class into container.
         *
         * @param string $class  Class name
         * @param mixed  $object Object
         * @param int    $type   How to resolve override
         *
         * @throws ElementExistsException When $type === ContainerInterface::ADD_THROW, and $class already exist
         *         in container
         */
        public function add(string $class, $object, int $type = self::ADD_OVERRIDE): void;

        /**
         * Resolve $class, and create new or fetch cached version
         *
         * @param string $class
         * @param array  $arguments
         * @param int    $type
         *
         * @return mixed
         */
        public function resolve(string $class,
                                array $arguments = [],
                                int $type = self::RESOLVE_TYPEHINT | self::RESOLVE_ADD);

        /**
         * Convert $this object into Psr Compatible container
         */
        public function psr(): PsrContainerInterface;
    }
