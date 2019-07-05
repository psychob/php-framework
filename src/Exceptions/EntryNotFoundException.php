<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Exceptions;

    class EntryNotFoundException extends FrameworkException
    {
        /** @var string */
        protected $key;

        /** @var string[] */
        protected $available;

        /**
         * EntryNotFoundException constructor.
         *
         * @param string          $key
         * @param string[]        $available
         * @param \Throwable|null $prev
         */
        public function __construct(string $key, array $available = [], \Throwable $prev = NULL)
        {
            $this->key = $key;
            $this->available = $available;

            parent::__construct(sprintf('Could not found key: %s', $key), 0, $prev);
        }

    }
