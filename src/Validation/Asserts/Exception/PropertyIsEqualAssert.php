<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts\Exception;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class PropertyIsEqualAssert extends BaseAssert
    {
        protected $object;
        protected $property;
        protected $value;

        /**
         * PropertyIsEqualAssert constructor.
         *
         * @param object $object
         * @param mixed $property
         * @param mixed $value
         * @param string $message
         * @param Throwable|null $previous
         */
        public function __construct($object,
            $property,
            $value,
            string $message = 'PropertyIsEqualAssert',
            Throwable $previous = NULL)
        {
            $this->object = $object;
            $this->property = $property;
            $this->value = $value;

            parent::__construct('propertyIsEqual',
                sprintf('%s: Object: %s property %s is not equal to %s', $message, Str::toType($object),
                    Str::toStr($property), Str::toRepr($value)), $previous);
        }

        /**
         * @return object
         */
        public function getObject(): object
        {
            return $this->object;
        }

        /**
         * @return mixed
         */
        public function getProperty()
        {
            return $this->property;
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }
    }
