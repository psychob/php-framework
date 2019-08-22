<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\ArrayProperties;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use Throwable;

    class ArrayAssertException extends AssertionFailureException
    {
        protected $array;
        protected $key;

        public function __construct($array,
            $key,
            string $assertionType,
            string $exceptionMessage,
            ?string $message = NULL,
            ?Throwable $previous = NULL)
        {
            $this->array = $array;
            $this->key = $key;

            parent::__construct($assertionType, $exceptionMessage, $message, -1, $previous);
        }

        /**
         * @return mixed
         */
        public function getArray()
        {
            return $this->array;
        }

        /**
         * @return mixed
         */
        public function getKey()
        {
            return $this->key;
        }
    }
