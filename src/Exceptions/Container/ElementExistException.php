<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Exceptions\Container;

    use PsychoB\Framework\Core\Utility\Str;
    use PsychoB\Framework\Exceptions\BaseException;
    use Throwable;

    class ElementExistException extends BaseException
    {
        /** @var string|int */
        protected $element;

        /** @var mixed */
        protected $value;

        /** @var array */
        protected $collection;

        /**
         * ElementExistException constructor.
         *
         * @param string|int     $element
         * @param mixed          $value
         * @param array          $collection
         * @param string|null    $message
         * @param Throwable|null $previous
         */
        public function __construct($element,
                                    $value,
                                    array $collection,
                                    string $message = 'Element already found in array',
                                    ?Throwable $previous = NULL)
        {
            $this->element = $element;
            $this->value = $value;
            $this->collection = $collection;

            parent::__construct(sprintf('%s: Key: %s is value: %s', $message, $element, Str::toStr($value, "???")), 0, $previous);
        }

        /**
         * @return int|string
         */
        public function getElement()
        {
            return $this->element;
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @return array
         */
        public function getCollection(): array
        {
            return $this->collection;
        }
    }
