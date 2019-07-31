<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    class PropertyIsNotEqualException extends AssertionException
    {
        /** @var string */
        protected $propertyName;

        /** @var mixed */
        protected $propertyValue;

        /**
         * PropertyIsNotEqualException constructor.
         *
         * @param mixed           $value
         * @param string          $propertyName
         * @param mixed           $propertyValue
         * @param string|null     $message
         * @param \Throwable|null $previous
         */
        public function __construct($value,
            string $propertyName,
            $propertyValue,
            ?string $message = NULL,
            ?\Throwable $previous = NULL)
        {
            $this->propertyName = $propertyName;
            $this->propertyValue = $propertyValue;

            parent::__construct($value, 'property-is-equal', 'Property value is not equal', $message, $previous);
        }

        /**
         * @return string
         */
        public function getPropertyName(): string
        {
            return $this->propertyName;
        }

        /**
         * @return mixed
         */
        public function getPropertyValue()
        {
            return $this->propertyValue;
        }
    }
