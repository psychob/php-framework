<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    class ArrayHasKeyException extends AssertionException
    {
        /** @var mixed */
        protected $key;

        /**
         * ArrayHasKeyException constructor.
         *
         * @param mixed           $obj
         * @param mixed           $key
         * @param string|null     $message
         * @param \Throwable|null $previous
         */
        public function __construct($obj, $key, ?string $message = NULL, ?\Throwable $previous = NULL)
        {
            $this->key = $key;

            parent::__construct($obj, 'has-no-key', 'Array has not key', $message, $previous);
        }

        /**
         * @return mixed
         */
        public function getKey()
        {
            return $this->key;
        }
    }
