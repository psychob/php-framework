<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class ValueIsNotEqualException extends AssertionException
    {
        /** @var mixed */
        protected $compare;

        /**
         * ValueIsNotEqualException constructor.
         *
         * @param mixed          $value
         * @param mixed          $toCompare
         * @param string|null    $message
         * @param Throwable|null $previous
         */
        public function __construct($value, $toCompare, ?string $message = NULL, Throwable $previous = NULL)
        {
            $this->compare = $toCompare;

            parent::__construct($value, 'is-equal', 'Values are not equals', $message, $previous);
        }

        /** @return mixed */
        public function getCompare()
        {
            return $this->compare;
        }
    }
