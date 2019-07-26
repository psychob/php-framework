<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ElementAlreadyExistException;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ElementNotFoundException;
    use PsychoB\Framework\Utility\Arr;

    /**
     * Class Container.
     *
     * This class is used to store all classes that were created by framework.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Container implements ContainerInterface
    {
        /** @var mixed[] */
        protected $container = [];

        /** @var PsrContainerInterface */
        protected $psr;

        public function __construct()
        {
            $this->add(Container::class, $this);
            $this->add(ContainerInterface::class, $this);

            $this->psr = new ContainerAdapter($this);
            $this->add(PsrContainerInterface::class, $this->psr);
        }

        /** @inheritDoc */
        public function get(string $id)
        {
            if (!$this->has($id)) {
                throw new ElementNotFoundException($this->container, $id, false);
            }

            return $this->container[$id];
        }

        /** @inheritDoc */
        public function has(string $id): bool
        {
            return array_key_exists($id, $this->container);
        }

        /** @inheritDoc */
        public function add(string $id, $obj, int $type = self::ADD_OVERRIDE): void
        {
            if ($type === self::ADD_IGNORE && $this->has($id)) {
                return;
            }

            if ($type === self::ADD_THROW && $this->has($id)) {
                throw new ElementAlreadyExistException($id, $this->container[$id]);
            }

            $this->container[$id] = $obj;

            Arr::sortByKey($this->container);
        }

        /** @inheritDoc */
        public function psr(): PsrContainerInterface
        {
            return $this->psr;
        }
    }
