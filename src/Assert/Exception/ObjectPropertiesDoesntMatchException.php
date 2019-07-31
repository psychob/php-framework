<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class ObjectPropertiesDoesntMatchException extends AssertionException
    {
        /** @var mixed[] */
        protected $props;

        /**
         * ObjectPropertiesDoesntMatchException constructor.
         *
         * @param mixed          $value
         * @param mixed[]        $props
         * @param string|null    $message
         * @param Throwable|null $previous
         */
        public function __construct($value, array $props, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            $this->props = $props;

            parent::__construct($value,
                'object-property-expectation',
                'Object didnt met expectation',
                $message,
                $previous);
        }

        /**
         * @return mixed[]
         */
        public function getProps(): array
        {
            return $this->props;
        }
    }
