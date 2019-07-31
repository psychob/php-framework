<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class TypeRequirementException extends AssertionException
    {
        /** @var mixed[]|string */
        protected $type;

        /** @var mixed[] */
        protected $prop;

        /** @var string|null */
        protected $message;

        /** @var Throwable */
        protected $previous;

        /**
         * TypeRequirementException constructor.
         *
         * @param mixed          $value
         * @param mixed[]|string $type
         * @param mixed[]        $prop
         * @param string|null    $message
         * @param Throwable      $previous
         */
        public function __construct($value, $type, array $prop, ?string $message = NULL, Throwable $previous = NULL)
        {
            $this->type = $type;
            $this->prop = $prop;
            $this->message = $message;
            $this->previous = $previous;

            parent::__construct($value, 'type-requirements', 'Type does not match requirements', $message, $previous);
        }
    }
