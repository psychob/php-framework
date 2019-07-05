<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv\Sources;

    use PsychoB\Framework\Exceptions\EntryNotFoundException;

    class CustomVarSource extends AbstractSource
    {
        protected $source = [];

        /**
         * CustomVarSource constructor.
         *
         * @param bool       $volatile Dont allow cache
         * @param array|null $source   Source
         */
        public function __construct(bool $volatile, array $source)
        {
            parent::__construct($volatile);

            $this->source = $source;
        }

        /**
         * @inheritDoc
         */
        public function get(string $value)
        {
            if (!$this->has($value)) {
                throw new EntryNotFoundException($value, array_keys($_ENV));
            }

            return $this->source[$value];
        }

        /**
         * @inheritDoc
         */
        public function has(string $value): bool
        {
            return array_key_exists($value, $this->source);
        }
    }
