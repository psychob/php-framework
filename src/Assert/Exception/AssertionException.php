<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use PsychoB\Framework\Exception\BaseException;

    class AssertionException extends BaseException
    {
        /** @var string */
        protected $assertionType;

        public function __construct(string $assertionType, string $type, string $message, \Throwable $previous = NULL)
        {
            $this->assertionType = $assertionType;

            parent::__construct(sprintf('%s: %s', $type, $message), 0, $previous);
        }

        /**
         * @return string
         */
        public function getAssertionType(): string
        {
            return $this->assertionType;
        }
    }
