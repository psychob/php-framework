<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Core\Exceptions\Containers;

    use RuntimeException;
    use Throwable;

    /**
     * Class ElementNotFoundException.
     *
     * This exception will be thrown when you are trying to access element that do not exist in collection.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class ElementNotFoundException extends RuntimeException
    {
        /** @var int|string */
        protected $key;

        /** @var array */
        protected $array;

        /** @var bool */
        protected $fullArray = true;

        /**
         * ElementNotFoundException constructor.
         *
         * @param int|string     $key       Which key you were trying to access
         * @param mixed[]        $array     Collection
         * @param bool           $fullArray Is this full collection or only keys
         * @param string         $message   Custom message
         * @param Throwable|NULL $previous  Previous Exception
         */
        public function __construct($key,
                                    $array,
                                    bool $fullArray = true,
                                    string $message = '',
                                    Throwable $previous = NULL)
        {
            /// TODO: Add suggestion on which probable element we want to use
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
