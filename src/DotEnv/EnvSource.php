<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv;

    use PsychoB\Framework\Exceptions\EntryNotFoundException;

    class EnvSource extends DotEnvBase
    {
        protected $cached = [];

        /**
         * EnvSource constructor.
         *
         * @param string       $basePath
         * @param mixed|string $file
         * @param bool|mixed   $isVolatile
         */
        public function __construct(?string $basePath, string $file, bool $isVolatile)
        {
            parent::__construct($isVolatile);

            if ($basePath === NULL) {
                $path = $file;
            } else {
                $path = $basePath . DIRECTORY_SEPARATOR . $file;
            }

            foreach (file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
                $hasComment = strpos($line, '#');
                if ($hasComment !== false) {
                    $line = substr($line, 0, $hasComment - 1);
                }

                $assign = strpos($line, '=');
                if ($assign === false) {
                    continue;
                }

                $key = substr($line, 0, $assign);
                $value = substr($line, $assign + 1);

                $this->cached[$key] = $this->parseValue($value);
            }
        }

        /** @inheritDoc */
        public function get(string $value)
        {
            if (!$this->has($value)) {
                throw new EntryNotFoundException($value, array_keys($this->cached));
            }

            return $this->cached[$value];
        }

        /** @inheritDoc */
        public function has(string $value): bool
        {
            return array_key_exists($value, $this->cached);
        }
    }
