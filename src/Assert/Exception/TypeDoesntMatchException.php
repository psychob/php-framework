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
        protected $obj;
        protected $types;

        /**
         * TypeDoesntMatchException constructor.
         *
         * @param                 $obj
         * @param                 $types
         * @param string|null     $message
         * @param Throwable|null  $previous
         */
        public function __construct($obj, $types, ?string $message = NULL, Throwable $previous = NULL)
        {
            $this->obj = $obj;
            $this->types = $types;

            parent::__construct('type-match', 'TypeDoesntMatchException', $message ?? 'Type didnt match specification',
                $previous);
        }

        /**
         * @return mixed
         */
        public function getObj()
        {
            return $this->obj;
        }

        /**
         * @return mixed
         */
        public function getTypes()
        {
            return $this->types;
        }
    }
