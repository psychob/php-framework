<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Exceptions\Container;

    use PsychoB\Framework\Exceptions\BaseException;
    use Throwable;

    class ElementNotFoundException extends BaseException
    {
        /** @var int|string */
        protected $key;

        /** @var array */
        protected $array;

        /** @var bool */
        protected $fullArray = true;

        public function __construct($key,
                                    $array,
                                    bool $fullArray = true,
                                    string $message = '',
                                    Throwable $previous = NULL)
        {
            parent::__construct(sprintf('%s: Element not found: %s', $message, $key), 0, $previous);

            $this->key = $key;
            $this->array = $array;
            $this->fullArray = $fullArray;
        }

        /**
         * @return int|string
         */
        public function getKey()
        {
            return $this->key;
        }

        /**
         * @return array
         */
        public function getArray(): array
        {
            return $this->array;
        }

        /**
         * @return bool
         */
        public function isFullArray(): bool
        {
            return $this->fullArray;
        }
    }
