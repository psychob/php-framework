<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert;

    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Exception\InvalidArgumentException;

    /**
     * Class AssertArgument
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @method static isTrue($obj)
     * @method static isFalse($obj)
     * @method static isEqual(mixed $left, mixed $right)
     * @method static typeRequirements(mixed $obj, array|string $type, mixed[] $properties)
     * @method static hasType($obj, mixed|string $type)
     * @method static isNotEmpty($obj)
     */
    class AssertArgument
    {
        /** @var string */
        protected $name;

        /** @var int */
        protected $position;

        /** @var string */
        protected $message;

        /**
         * AssertArgument constructor.
         *
         * @param string $name
         * @param int    $position
         * @param string $message
         */
        public function __construct(?string $name, ?int $position, ?string $message)
        {
            $this->name = $name;
            $this->position = $position;
            $this->message = $message;
        }

        public function __call($name, $arguments)
        {
            try {
                Assert::__callStatic($name, $arguments);
            } catch (AssertionException $a) {
                throw new InvalidArgumentException($this->name, $this->position, $this->message, $a);
            }
        }
    }
