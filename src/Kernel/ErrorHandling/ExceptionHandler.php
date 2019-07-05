<?php
    //
    // psychob/ja
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel\ErrorHandling;

    use PsychoB\DependencyInjection\Container;
    use Throwable;

    /**
     * Exception Handler.
     *
     * This class handles exception that are not intercepted by any catch (...) on the way. This class will only be used
     * at point after Kernel initializes it, and before Environment sets up Application Driver.
     *
     * Drivers should register their own ExceptionHandlerInterface after they are initialized.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class ExceptionHandler
    {
        /** @var Container */
        protected $container;

        /**
         * ExceptionHandler constructor.
         *
         * @param Container $container
         */
        public function __construct(Container $container)
        {
            $this->container = $container;
        }

        public function catchException(Throwable $t)
        {
            /** @var ExceptionHandlerInterface $eh */
            $eh = $this->container->get(ExceptionHandlerInterface::class);

            $eh->catchException($t);
        }
    }
