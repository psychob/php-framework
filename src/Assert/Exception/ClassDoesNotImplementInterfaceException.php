<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class ClassDoesNotImplementInterfaceException extends AssertionException
    {
        /** @var string|string[] */
        protected $interfaces;

        /**
         * ClassDoesNotImplementInterfaceException constructor.
         *
         * @param object|string   $obj
         * @param string|string[] $interfaces
         * @param string|null     $message
         * @param Throwable|null $previous
         */
        public function __construct($obj, $interfaces, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            $this->interfaces = $interfaces;

            parent::__construct($obj, 'implements-interface', 'object or class does not implements interface', $message,
                $previous);
        }

        /**
         * @return string|string[]
         */
        public function getInterfaces()
        {
            return $this->interfaces;
        }
    }
