<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv\Sources;

    use PsychoB\Framework\Exceptions\EntryNotFoundException;

    /**
     * Source for environmental variables fetched from environment.
     *
     * This class will always load variables from getenv.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since 0.1
     */
    class GetEnvSource extends AbstractSource
    {
        /**
         * EnvVarSource constructor.
         *
         * @param bool $isVolatile
         */
        public function __construct(bool $isVolatile)
        {
            parent::__construct($isVolatile);
        }

        /** @inheritDoc */
        public function get(string $value)
        {
            if (!$this->has($value)) {
                throw new EntryNotFoundException($value);
            }

            return $this->parseValue(getenv($value));
        }

        /** @inheritDoc */
        public function has(string $value): bool
        {
            return getenv($value) !== false;
        }
    }
