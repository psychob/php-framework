<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\System;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use PsychoB\Framework\Exception\InvalidArgumentException;

    final class ArgumentAssert extends AssertDatabaseTrait
    {
        /** @var string|null */
        protected $message;

        /** @var int|null */
        protected $position;

        /** @var string|null */
        protected $name;

        /**
         * ArgumentAssert constructor.
         *
         * @param string $message
         * @param int    $position
         * @param string $name
         */
        public function __construct(?string $message, ?int $position, ?string $name)
        {
            $this->message = $message;
            $this->position = $position;
            $this->name = $name;
        }

        public function __call(string $name, $arguments)
        {
            try {
                return static::__callStatic($name, $arguments);
            } catch (AssertionFailureException $e) {
                throw new InvalidArgumentException($this->name, $this->position, $this->message, $e);
            }
        }
    }
