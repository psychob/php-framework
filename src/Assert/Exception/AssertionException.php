<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use PsychoB\Framework\Exception\BaseException;
    use Throwable;

    /**
     * Base class for assertion exception.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class AssertionException extends BaseException
    {
        /** @var string */
        protected $assertionType;

        /** @var mixed */
        protected $value;

        public function __construct($obj,
            string $assertionType,
            string $exceptionClass,
            string $exceptionMessage,
            ?string $customMessage = NULL,
            Throwable $previous = NULL)
        {
            $this->assertionType = $assertionType;
            $this->value = $obj;

            parent::__construct(sprintf('%s: %s %s', $exceptionClass, $exceptionMessage, $customMessage), 0, $previous);
        }

        /** @return string */
        public function getAssertionType(): string
        {
            return $this->assertionType;
        }

        /** @return mixed */
        public function getValue()
        {
            return $this->value;
        }
    }
