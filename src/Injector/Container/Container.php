<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\Injector\Exceptions\ElementExistsException;
    use PsychoB\Framework\Injector\Exceptions\ElementNotFoundException;

    class Container implements ContainerInterface
    {
        protected $container = [];

        /** @inheritDoc */
        public function has(string $class): bool
        {
            return array_key_exists($class, $this->container);
        }

        /** @inheritDoc */
        public function get(string $class)
        {
            if (!$this->has($class)) {
                throw new ElementNotFoundException($class, array_keys($this->container));
            }

            return $this->container[$class];
        }

        /** @inheritDoc */
        public function add(string $class, $object, int $type = self::ADD_OVERRIDE): void
        {
            if ($type === self::ADD_THROW && $this->has($class)) {
                throw new ElementExistsException($class, $this->container[$class]);
            }

            $this->container[$class] = $object;
        }

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
                                int $type = self::RESOLVE_TYPEHINT | self::RESOLVE_ADD)
        {
            // TODO: Implement resolve() method.
        }

        /**
         * Convert $this object into Psr compatibile container
         */
        public function psr(): PsrContainerInterface
        {
            return new PsrContainerAdapter($this);
        }
    }
