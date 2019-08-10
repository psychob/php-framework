<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Testing\Traits;

    use PsychoB\Framework\Config\ConfigManager;
    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\FrameworkSource;
    use PsychoB\Framework\Utility\Path;
    use PsychoB\Framework\Utility\Ref;
    use Tests\PsychoB\Framework\Mock\Application\Directories\DirectoryManagerTraitMock;

    trait EnableFrameworkConfigurationInTestCaseTrait
    {
        /** @var ConfigManagerInterface|ConfigManager */
        protected $_pbfw__config = NULL;

        public function EnableFrameworkConfigurationInTestCaseTrait_setUp(): void
        {
            $discovery = new DirectoryManagerTraitMock('', Path::realpath(Path::join(FrameworkSource::CURRENT_DIR, '..')));
            $this->_pbfw__config = new ConfigManager($discovery);

            if (Ref::hasTrait($this, EnableContainerInTestCaseTrait::class, true)) {
                /** @var $this EnableContainerInTestCaseTrait|EnableFrameworkConfigurationInTestCaseTrait */
                $this->_pbfw__container->add(ConfigManagerInterface::class, $this->_pbfw__config);
            }
        }

        public function EnableFrameworkConfigurationInTestCaseTrait_tearDown(): void
        {
            $this->_pbfw__config = NULL;
        }

        public static function EnableFrameworkConfigurationInTestCaseTrait_priority(): int
        {
            return 5;
        }
    }
