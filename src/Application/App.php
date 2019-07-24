<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application;

    use PsychoB\Framework\Container\Container;
    use PsychoB\Framework\Container\ContainerInterface;

    class App implements AppInterface
    {
        /** @var string */
        protected $basePath;

        /** @var ContainerInterface */
        protected $container;

        /**
         * App constructor.
         *
         * @param string $basePath
         */
        public function __construct(string $basePath)
        {
            $this->basePath = $basePath;
        }

        public function run()
        {
            $this->container = new Container();
            $this->container->add(App::class, $this);
            $this->container->add(AppInterface::class, $this);
        }
    }
