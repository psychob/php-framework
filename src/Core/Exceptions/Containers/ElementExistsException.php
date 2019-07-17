<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Core\Exceptions\Containers;

    use PsychoB\Framework\Core\Utility\Str;
    use RuntimeException;
    use Throwable;

    class ElementExistsException extends RuntimeException
    {
        protected $key;
        protected $value;

        /**
         * ElementExistsException constructor.
         *
         * @param mixed          $key
         * @param mixed          $value
         * @param string         $message
         * @param Throwable|null $previous
         */
        public function __construct($key,
                                    $value,
                                    string $message = 'Element already exists',
                                    ?Throwable $previous = NULL)
        {
            $this->key = $key;
            $this->value = $value;

            parent::__construct(sprintf('%s: element %s already exists with value: %s', $message, $key, Str::toStr($value)),
                                0, $previous);
        }

        /**
         * @return mixed
         */
        public function getKey()
        {
            return $this->key;
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }
    }
