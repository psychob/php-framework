<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Value;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ValueIsFullException extends AssertionFailureException
    {
        /**
         * @var mixed
         */
        private $value;

        /**
         * ValueIsFullException constructor.
         *
         * @param mixed          $value
         * @param string|null    $message
         * @param Throwable|null $previous
         */
        public function __construct($value, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            $this->value = $value;

            parent::__construct('is-empty', sprintf('Value: %s is not empty', Str::toRepr($value)), $message, -1,
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
