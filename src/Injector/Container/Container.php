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

        /**
         * Container constructor.
         */
        public function __construct()
        {
            $this->add(Container::class, $this);
            $this->add(ContainerInterface::class, $this);
            $this->add(PsrContainerInterface::class, new PsrContainerAdapter($this));
        }

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
            if ($type !== self::ADD_OVERRIDE && $this->has($class)) {
                switch ($type) {
                    case self::ADD_THROW:
                        throw new ElementExistsException($class, $this->container[$class]);

                    case self::ADD_IGNORE:
                        return;
                }
            }

            $this->container[$class] = $object;
        }

        /** @inheritDoc */
        public function resolve(string $class,
                                array $arguments = [],
                                int $type = self::RESOLVE_TYPEHINT | self::RESOLVE_ADD)
        {
            // TODO: Implement resolve() method.
        }

        /** @inheritDoc */
        public function psr(): PsrContainerInterface
        {
            return $this->get(PsrContainerInterface::class);
        }
    }
