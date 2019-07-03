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

        /**
         * EnvSource constructor.
         *
         * @param string       $basePath
         * @param mixed|string $file
         * @param bool|mixed   $isVolatile
         */
        public function __construct(string $basePath, string $file, bool $isVolatile)
        {
            parent::__construct($isVolatile);
        }

        /** @inheritDoc */
        public function get(string $value)
        {
            // TODO: Implement get() method.
        }

        /** @inheritDoc */
        public function has(string $value): bool
        {
            // TODO: Implement has() method.
        }
    }
