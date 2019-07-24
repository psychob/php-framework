<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Exception;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class BaseElementAlreadyExistException extends BaseException
    {
        /** @var mixed */
        protected $element;

        /** @var mixed */
        protected $oldValue;

        /**
         * BaseElementAlreadyExistException constructor.
         *
         * @param mixed          $element
         * @param mixed          $oldValue
         * @param string         $message
         * @param Throwable|null $previous
         */
        public function __construct($element, $oldValue, string $message = self::class, ?Throwable $previous = NULL)
        {
            $this->element = $element;
            $this->oldValue = $oldValue;

            parent::__construct(sprintf('%s: Element %s already exist in container with value: %s', $message,
                                        Str::toInformableString($element), Str::toInformableString($oldValue)), 0,
                                $previous);
        }

        /**
         * @return mixed
         */
        public function getElement()
        {
            return $this->element;
        }

        /**
         * @return mixed
         */
        public function getOldValue()
        {
            return $this->oldValue;
        }
    }
