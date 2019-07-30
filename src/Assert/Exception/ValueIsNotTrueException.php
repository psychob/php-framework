<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    class ValueIsNotTrueException extends AssertionException
    {
        protected $value;

        public function __construct($value, ?string $message = NULL, \Throwable $previous = NULL)
        {
            $this->value = $value;

            parent::__construct("is-true", 'ValueIsNotTrueException', $message ?? 'Value does not equal to true',
                $previous);
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }
    }
