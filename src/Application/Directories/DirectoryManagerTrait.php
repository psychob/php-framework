<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Application\Directories;

    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Path;
    use Symfony\Component\Finder\Finder;

    /**
     * Trait DirectoryManagerTrait
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @mixin DirectoryDiscoveryInterface
     * @mixin DirectoryAdderInterface
     */
    trait DirectoryManagerTrait
    {
        protected $appBasePath = "";
        protected $frameworkBasePath = "";

        protected $basePaths = [];
        protected $pathClassifications = [];

        /** @inheritDoc */
        public function addDirectory(string $module, string $path): void
        {
            if (!Arr::contains($this->basePaths, $path)) {
                $this->basePaths[] = $path;
            }

            if (!Arr::containsRecursive($this->pathClassifications, [$module], $path)) {
                $this->pathClassifications[$module] = $path;
            }
        }

        /** @inheritDoc */
        public function getBaseDirectories(): array
        {
            return $this->basePaths;
        }

        /** @inheritDoc */
        public function getFrameworkDirectory(): string
        {
            return $this->frameworkBasePath;
        }

        /** @inheritDoc */
        public function getApplicationDirectory(): string
        {
            return $this->appBasePath;
        }

        /** @inheritDoc */
        public function fetchPathsFor(string $module, ?string $subPath = NULL): array
        {
            $finder = new Finder();
            $finder->in(Path::join($this->frameworkBasePath, 'resources', $module));
            foreach ($this->pathClassifications[$module] ?? [] as $path) {
                $finder->in($path);
            }
            $finder->in(Path::join($this->appBasePath, 'resources', $module));

            $finder->ignoreUnreadableDirs(true);
            $finder->ignoreDotFiles(true);
            $finder->files();

            if ($subPath) {
                $finder->name($subPath . '*');
            }

            return Arr::pluck($finder, 'getPathname');
        }
    }
