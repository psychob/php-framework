<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Validation\Asserts\Exception;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ValueIsNotTrueAssert extends BaseAssert
    {
        /** @var mixed */
        protected $value;

        /**
         * ValueIsNotTrueAssert constructor.
         *
         * @param mixed          $value
         * @param string         $message
         * @param Throwable|null $previous
         */
        public function __construct($value, string $message = 'ValueIsNotTrueAssert', ?Throwable $previous = NULL)
        {
            $this->value = $value;

            parent::__construct('isTrue',
                sprintf('%s: Element: %s is not equal to true', $message, Str::toRepr($value)), $previous);
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }
    }
