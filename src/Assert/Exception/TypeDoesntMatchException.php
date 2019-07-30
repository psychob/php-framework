<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class TypeDoesntMatchException extends AssertionException
    {
        protected $types;

        /**
         * TypeDoesntMatchException constructor.
         *
         * @param mixed          $obj
         * @param string|array   $types
         * @param string|null    $message
         * @param Throwable|null $previous
         */
        public function __construct($obj, $types, ?string $message = NULL, Throwable $previous = NULL)
        {
            $this->types = $types;

            parent::__construct($obj,
                'type-match',
                'TypeDoesntMatchException',
                'Type didnt match specification',
                $message,
                $previous);
        }

        /**
         * @return mixed
         */
        public function getTypes()
        {
            return $this->types;
        }
    }
