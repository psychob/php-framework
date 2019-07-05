<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv;

    use PsychoB\Framework\DotEnv\Sources\CustomVarSource;
    use PsychoB\Framework\DotEnv\Sources\DeferredDotEnvSource;
    use PsychoB\Framework\DotEnv\Sources\DotEnvSource;
    use PsychoB\Framework\DotEnv\Sources\EnvVarSource;
    use PsychoB\Framework\DotEnv\Sources\GetEnvSource;

    class DotEnv
    {
        /**
         * Load variables from .env file
         */
        public const ORDER_DOT_ENV = 1;

        /**
         * Load variables from $_ENV server variables
         */
        public const ORDER_GETENV = 2;

        /**
         * Load variables from .env.{environment} file
         */
        public const ORDER_DOT_ENV_ENVIRONMENT = 3;

        /**
         * Load variables from custom source
         */
        public const ORDER_CUSTOM = 4;

        /**
         * Load variables from $_ENV
         */
        public const ORDER_ENV_VAR = 5;

        /**
         * Load variables from custom array
         */
        public const ORDER_ENV_CUSTOM = 6;
        /**
         * @var DotEnvSourceInterface[]
         */
        protected $order = [];

        /**
         * Values cached for current execution
         *
         * @var string[]
         */
        protected $cached = [];

        public function __construct(string $basePath, ...$sources)
        {
            foreach ($sources as $source) {
                $type = $source;
                $isVolatile = false;
                $customLoader = NULL;
                $file = '.env';
                $envEnv = 'APP_ENV';

                if (is_array($source)) {
                    $type = $source['type'];
                    $isVolatile = $source['volatile'] ?? false;
                    $customLoader = $source['bind'] ?? NULL;
                    $file = $source['file'] ?? '.env';
                    $envEnv = $source['env'] ?? $envEnv;
                }

                switch ($type) {
                    case self::ORDER_DOT_ENV:
                        $this->order[] = new DotEnvSource($basePath, $file, $isVolatile);
                        break;

                    case self::ORDER_CUSTOM:
                        $this->order[] = $customLoader;
                        break;

                    case self::ORDER_DOT_ENV_ENVIRONMENT:
                        $this->order[] = new DeferredDotEnvSource($basePath, $file, $envEnv, $isVolatile, $this);
                        break;

                    case self::ORDER_GETENV:
                        $this->order[] = new GetEnvSource($isVolatile);
                        break;

                    case self::ORDER_ENV_VAR:
                        $this->order[] = new EnvVarSource($isVolatile);
                        break;

                    case self::ORDER_ENV_CUSTOM:
                        $this->order[] = new CustomVarSource($isVolatile, $customLoader);
                        break;
                }
            }
        }

        public function get(string $key, $default = NULL)
        {
            if (array_key_exists($key, $this->cached)) {
                return $this->cached[$key];
            }

            /** @var DotEnvSourceInterface $source */
            foreach ($this->order as $source) {
                if ($source->has($key)) {
                    $value = $source->get($key);

                    if (!$source->isVolatile()) {
                        $this->cached[$key] = $value;
                    }

                    return $value;
                }
            }

            return $default;
        }

        public function set(string $key, $value): void
        {
            $this->cached[$key] = $value;
        }
    }
