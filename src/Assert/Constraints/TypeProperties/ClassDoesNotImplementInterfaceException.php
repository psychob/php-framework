<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\TypeProperties;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ClassDoesNotImplementInterfaceException extends AssertionFailureException
    {
        /** @var object|string */
        private $class;

        /** @var string */
        private $interface;

        public function __construct($class,
            string $interface,
            ?string $message,
            ?Throwable $previous = NULL)
        {
            parent::__construct('class-implements',
                sprintf('Class %s does not implement interface %s', is_string($class) ? $class : Str::toType($class),
                    $interface), $message, -1, $previous);
            $this->class = $class;
            $this->interface = $interface;
        }

        /**
         * @return object|string
         */
        public function getClass()
        {
            return $this->class;
        }

        /**
         * @return string
         */
        public function getInterface(): string
        {
            return $this->interface;
        }
    }
