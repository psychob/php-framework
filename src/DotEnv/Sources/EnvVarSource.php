<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv\Sources;

    use PsychoB\Framework\Exceptions\EntryNotFoundException;

    /**
     * Source for environmental variables defined in $_ENV.
     *
     * This class is useful when testing, as phpunit will set $_ENV variable and not getenv/putenv
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class EnvVarSource extends AbstractSource
    {
        protected $source = [];

        /**
         * EnvVarSource constructor.
         *
         * @param bool       $volatile Dont allow cache
         * @param array|null $source   Source
         */
        public function __construct(bool $volatile, ?array $source = NULL)
        {
            parent::__construct($volatile);

            if ($source === NULL) {
                $source = $_ENV;
            }

            $this->source = $source;
        }

        /** @inheritDoc */
        public function get(string $value)
        {
            if (!$this->has($value)) {
                throw new EntryNotFoundException($value, array_keys($_ENV));
            }

            return $this->source[$value];
        }

        /** @inheritDoc */
        public function has(string $value): bool
        {
            return array_key_exists($value, $this->source);
        }
    }
