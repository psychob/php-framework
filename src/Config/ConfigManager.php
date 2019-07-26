<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Config;

    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Path;
    use PsychoB\Framework\Utility\Str;

    /**
     * Class ConfigManager
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class ConfigManager implements ConfigManagerInterface
    {
        protected $configPaths = [];
        protected $loaded = [];
        protected $container = [];

        /**
         * ConfigManager constructor.
         *
         * @param string $frameworkPath
         * @param string $appPath
         */
        public function __construct(string $frameworkPath, string $appPath)
        {
            $this->configPaths = [
                $frameworkPath,
                $appPath,
            ];
        }

        /** @inheritDoc */
        public function get(string $key, $default = NULL)
        {
            $components = Str::explode($key, '.');

            if (!$this->hasLoaded($components[0])) {
                $this->load($components[0]);
            }

            return Arr::recursiveGet($this->container, $components, $default);
        }

        private function hasLoaded(string $component): bool
        {
            return Arr::has($this->loaded, $component);
        }

        private function load(string $component): void
        {
            $branch = [];

            foreach ($this->configPaths as $path) {
                $branch[] = $this->loadPath($path, $component);
            }

            $this->container[$component] = $this->mergeBranches($branch);
        }

        protected function loadPath(string $path, string $component): array
        {
            $path = Path::join($path, $component . '.php');
            $content = $this->parseFile($path);

            $this->loaded[$component][] = $path;

            return $content;
        }

        protected function parseFile(string $path): array
        {
            if (Path::fileExists($path)) {
                return __nondirect_include($path);
            }

            return [];
        }

        private function mergeBranches(array $branch): array
        {
            return Arr::merge(Arr::MERGE_USE_LATEST | Arr::MERGE_RECURSIVE, ...$branch);
        }
    }

    /** @internal */
    function __nondirect_include(string $path)
    {
        return include($path);
    }
