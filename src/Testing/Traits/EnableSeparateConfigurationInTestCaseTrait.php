<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing\Traits;

    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\Utility\Ref;
    use Tests\PsychoB\Framework\Mock\Config\ArrayConfigManagerMock;

    trait EnableSeparateConfigurationInTestCaseTrait
    {
        protected $_pbfw__config = NULL;

        public function EnableSeparateConfigurationInTestCaseTrait_setUp(): void
        {
            $this->_pbfw__config = new ArrayConfigManagerMock([]);

            if (Ref::hasTrait($this, EnableContainerInTestCaseTrait::class)) {
                /** @var $this EnableContainerInTestCaseTrait|EnableSeparateConfigurationInTestCaseTrait */
                $this->_pbfw__container->add(ConfigManagerInterface::class, $this->_pbfw__config);
            }
        }

        public function EnableSeparateConfigurationInTestCaseTrait_tearDown(): void
        {
            $this->_pbfw__config = NULL;
        }

        public function EnableSeparateConfigurationInTestCaseTrait_priority(): int
        {
            return 5;
        }
    }
