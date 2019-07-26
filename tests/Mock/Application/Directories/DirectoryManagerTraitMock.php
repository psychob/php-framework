<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Application\Directories;

    use PsychoB\Framework\Application\Directories\DirectoryAdderInterface;
    use PsychoB\Framework\Application\Directories\DirectoryDiscoveryInterface;
    use PsychoB\Framework\Application\Directories\DirectoryManagerTrait;

    class DirectoryManagerTraitMock implements DirectoryAdderInterface, DirectoryDiscoveryInterface
    {
        use DirectoryManagerTrait;

        /**
         * DirectoryManagerTraitMock constructor.
         *
         * @param string $appBasePath
         * @param string $frameworkBasePath
         */
        public function __construct(string $appBasePath, string $frameworkBasePath)
        {
            $this->appBasePath = $appBasePath;
            $this->frameworkBasePath = $frameworkBasePath;
        }
    }
