<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints;

    use PsychoB\Framework\Exception\BaseException;
    use Throwable;

    abstract class AssertionFailureException extends BaseException
    {
        /** @var string */
        protected $assertionType;

        /** @var string */
        private $exceptionMessage;

        /** @var string|null */
        private $customMessage;

        public function __construct(string $assertionType,
            string $exceptionMessage,
            ?string $customMessage = NULL,
            int $code = -1,
            ?Throwable $previous = NULL)
        {
            $this->assertionType = $assertionType;
            $this->exceptionMessage = $exceptionMessage;
            $this->customMessage = $customMessage;

            parent::__construct($this->generateMessage(), $code, $previous);
        }

        private function generateMessage(): string
        {
            if ($this->customMessage) {
                return sprintf('%s: %s', $this->exceptionMessage, $this->customMessage);
            }

            return $this->exceptionMessage;
        }

        /**
         * @return string
         */
        public function getAssertionType(): string
        {
            return $this->assertionType;
        }

        /**
         * @return string
         */
        public function getExceptionMessage(): string
        {
            return $this->exceptionMessage;
        }

        /**
         * @return string|null
         */
        public function getCustomMessage(): ?string
        {
            return $this->customMessage;
        }
    }
