<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Container;

    use Psr\Container\ContainerInterface as PsrContainerInterface;
    use PsychoB\Framework\Injector\Exceptions\CanNotRetrieveElementException;
    use PsychoB\Framework\Injector\Exceptions\ElementNotFoundException;

    class PsrContainerAdapter implements PsrContainerInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /**
         * PsrContainerAdapter constructor.
         *
         * @param ContainerInterface $container
         */
        public function __construct(ContainerInterface $container)
        {
            $this->container = $container;
        }

        /** @inheritDoc */
        public function has($id)
        {
            return $this->container->has($id);
        }

        /** @inheritDoc */
        public function get($id)
        {
            if (!$this->has($id)) {
                throw new ElementNotFoundException($id, []);
            }

            try {
                return $this->container->get($id);
            } catch (\Exception $e) {
                throw new CanNotRetrieveElementException($id, $e);
            }
        }
    }
