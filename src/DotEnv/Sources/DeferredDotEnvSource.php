<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv\Sources;

    use PsychoB\Framework\DotEnv\DotEnv;
    use PsychoB\Framework\DotEnv\Exceptions\EnvNotFoundException;

    class DeferredDotEnvSource extends AbstractSource
    {
        /** @var string|null */
        protected $baseFile;

        /** @var string */
        protected $file;

        /** @var string */
        protected $envVar;

        /** @var null|DotEnvSource|bool */
        protected $source;

        /** @var DotEnv */
        protected $parent;

        /**
         * DeferredDotEnvSource constructor.
         *
         * @param string|null $baseFile
         * @param string      $file
         * @param string      $envVar
         * @param bool        $isVolatile
         */
        public function __construct(?string $baseFile, string $file, string $envVar, bool $isVolatile, DotEnv $parent)
        {
            $this->baseFile = $baseFile;
            $this->file = $file;
            $this->envVar = $envVar;
            $this->parent = $parent;

            parent::__construct($isVolatile);
        }

        /**
         * @inheritDoc
         */
        public function get(string $value)
        {
            $this->ensureSource();

            if ($this->source === false) {
                throw new EnvNotFoundException($value);
            }

            return $this->source->get($value);
        }

        /**
         * @inheritDoc
         */
        public function has(string $value): bool
        {
            // unless we already loaded source, we are never responsible for {$this->envVar} variable
            // this will prevent infinite redirection
            if ($this->source === null && $this->envVar === $value) {
                return false;
            }

            $this->ensureSource();

            return !($this->source === false) && $this->source->has($value);
        }

        private function ensureSource(): void
        {
            if ($this->source === null) {
                $environment = $this->parent->get($this->envVar, NULL);

                if ($environment !== NULL) {
                    $this->source = new DotEnvSource($this->baseFile, $this->file . ".{$environment}", $this->volatile);
                } else {
                    $this->source = false;
                }
            }
        }
    }
