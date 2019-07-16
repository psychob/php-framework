<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\DependencyInjection\PsrContainerAdapter;
    use PsychoB\Framework\DependencyInjection\Exceptions\ElementAlreadyExistException;
    use PsychoB\Framework\DependencyInjection\Exceptions\ElementAlreadyExistsException;
    use PsychoB\Framework\DependencyInjection\Exceptions\ElementNotFoundException;
    use PsychoB\Framework\DependencyInjection\Injector\Injector;
    use PsychoB\Framework\DependencyInjection\Injector\InjectorInterface;
    use PsychoB\Framework\DependencyInjection\Relation\RelationDatabase;
    use PsychoB\Framework\DependencyInjection\Relation\RelationDatabaseInterface;

    class Container implements ContainerInterface
    {
        /** @var mixed[] */
        protected $container = [];

        /** @var RelationDatabase */
        protected $relations = NULL;

        /**
         * Container constructor.
         *
         * @param InjectorInterface|null         $injector
         * @param RelationDatabaseInterface|null $relations
         */
        public function __construct(InjectorInterface $injector = NULL, RelationDatabaseInterface $relations = NULL)
        {
            if (!$relations) {
                $relations = new RelationDatabase();
                $this->add(RelationDatabase::class, $relations);
            }

            if (!$injector) {
                $injector = new Injector($this, $relations);
                $this->add(Injector::class, $injector);
            }

            $this->add(InjectorInterface::class, $injector);
            $this->add(RelationDatabaseInterface::class, $relations);
            $this->relations = $relations;
        }

        /** @inheritDoc */
        public function has(string $key): bool
        {
            return array_key_exists($key, $this->container) && $this->relations->has($key);
        }

        /** @inheritDoc */
        public function get(string $key)
        {
            if (array_key_exists($key, $this->container)) {
                return $this->container[$key];
            }

            if ($this->relations->has($key)) {
                return $this->get(Injector::class)->make($key);
            }

            throw new ElementNotFoundException($key,
                                               array_merge(array_keys($this->container), $this->relations->keys()),
                                               false);
        }

        /** @inheritDoc */
        public function add(string $key, $value, int $type = self::TYPE_OVERRIDE): void
        {
            if ($type === self::TYPE_EXCEPTION_ON_OVERRIDE && array_key_exists($key, $this->container)) {
                throw new ElementAlreadyExistException($key, $this->container[$key], $this->container);
            }

            $this->container[$key] = $value;
        }

        /** @inheritDoc */
        public function psr(): PsrContainerInterface
        {
            return new PsrContainerAdapter($this);
        }
    }
