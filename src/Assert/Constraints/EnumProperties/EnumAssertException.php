<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\EnumProperties;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class EnumAssertException extends AssertionFailureException
    {
        /** @var int|string */
        protected $value;

        /** @var int[string]|string[string] */
        protected $availableValues;

        public function __construct($value,
            array $availableValues,
            string $assert,
            string $exceptionMessage,
            ?string $message = NULL,
            ?Throwable $previous = NULL)
        {
            $this->value = $value;
            $this->availableValues = $availableValues;

            parent::__construct($assert, $this->generateExceptionMessage($exceptionMessage), $message, -1, $previous);
        }

        /**
         * @return int|string
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @return int
         */
        public function getAvailableValues()
        {
            return $this->availableValues;
        }

        private function generateExceptionMessage(string $exceptionMessage): string
        {
            /// TODO: Generate suggestion
            return sprintf('Value %s is not %s available values: %s',
                Str::toRepr($this->value),
                $exceptionMessage,
                Str::toRepr($this->availableValues));
        }
    }
