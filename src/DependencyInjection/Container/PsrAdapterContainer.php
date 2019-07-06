<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Container;

    use Exception;
    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\DependencyInjection\Exceptions\PsrContainerException;
    use PsychoB\Framework\DependencyInjection\Exceptions\PsrNotFoundException;

    /**
     * Adapter for ContainerInterface
     *
     * This is done to have compatibility with psr/container interface.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class PsrAdapterContainer implements PsrContainerInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /**
         * PsrAdapterContainer constructor.
         *
         * @param ContainerInterface $container
         */
        public function __construct(ContainerInterface $container)
        {
            $this->container = $container;
        }

        /** @inheritDoc */
        public function get($id)
        {
            if (!$this->has($id)) {
                throw new PsrNotFoundException($id);
            }

            try {
                return $this->container->get($id);
            } catch (Exception $e) {
                throw new PsrContainerException($id, [], $e);
            }
        }

        /** @inheritDoc */
        public function has($id)
        {
            return $this->container->has($id);
        }
    }
