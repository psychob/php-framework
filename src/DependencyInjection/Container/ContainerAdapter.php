<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Container;

    use Exception;
    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\DependencyInjection\Container\Exception\ErrorRetrievingElementException;
    use PsychoB\Framework\DependencyInjection\Container\Exception\PsrElementNotFoundException;

    class ContainerAdapter implements PsrContainerInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /**
         * ContainerAdapter constructor.
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
                throw new PsrElementNotFoundException($id);
            }

            try {
                return $this->container->get($id);
            } catch (Exception $e) {
                throw new ErrorRetrievingElementException($id, '', $e);
            }
        }

        /** @inheritDoc */
        public function has($id)
        {
            return $this->container->has($id);
        }
    }
