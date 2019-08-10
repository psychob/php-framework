<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing\Traits;

    use PsychoB\Framework\DependencyInjection\Container\Container;
    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;

    trait EnableContainerInTestCaseTrait
    {
        /** @var ContainerInterface */
        private $_pbfw__container = NULL;

        protected function getContainer(): ContainerInterface
        {
            return $this->_pbfw__container;
        }

        protected function swapContainer(ContainerInterface $container): ContainerInterface
        {
            $ret = $this->_pbfw__container;
            $this->_pbfw__container = $container;

            return $ret;
        }

        public function EnableContainerInTestCaseTrait_setUp(): void
        {
            $this->_pbfw__container = new Container();
        }

        public function EnableContainerInTestCaseTrait_tearDown(): void
        {
            $this->_pbfw__container = NULL;
        }

        public function EnableContainerInTestCaseTrait_priority(): int
        {
            return 0;
        }
    }
