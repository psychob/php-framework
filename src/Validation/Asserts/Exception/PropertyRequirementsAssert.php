<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts\Exception;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class PropertyRequirementsAssert extends BaseAssert
    {
        protected $obj;

        /** @var mixed[] */
        protected $properties;

        /**
         * PropertyRequirementsAssert constructor.
         *
         * @param                 $obj
         * @param mixed[]         $properties
         * @param string          $message
         * @param Throwable|null  $previous
         */
        public function __construct($obj,
            array $properties,
            string $message = 'PropertyRequirementsAssert',
            Throwable $previous = NULL)
        {
            $this->obj = $obj;
            $this->properties = $properties;

            parent::__construct("propertyRequirements",
                sprintf('%s: Object: %s properties %s dosen\'t have meet requirements', $message, Str::toType($obj),
                    Str::toRepr($properties)), $previous);
        }

    }
