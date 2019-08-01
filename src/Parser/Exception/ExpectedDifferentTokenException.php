<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Exception;

    use PsychoB\Framework\Exception\BaseException;
    use PsychoB\Framework\Parser\Tokens\TokenInterface;
    use Throwable;

    class ExpectedDifferentTokenException extends BaseException
    {
        /** @var array|string */
        protected $expectedToken;

        /** @var TokenInterface */
        protected $token;

        /** @var TokenInterface[]|null */
        protected $allTokens;

        /** @var int|null */
        protected $currentIdx;

        /** @var string|null */
        protected $fileName;

        /**
         * ExpectedDifferentTokenException constructor.
         *
         * @param array|string          $expectedToken
         * @param TokenInterface        $token
         * @param TokenInterface[]|null $allTokens
         * @param string|null           $filePath
         * @param int|null              $currentIdx
         * @param string|null           $message
         * @param Throwable|null        $previous
         */
        public function __construct($expectedToken,
            TokenInterface $token,
            ?string $filePath = NULL,
            ?array $allTokens = NULL,
            ?int $currentIdx = NULL,
            ?string $message = NULL,
            ?Throwable $previous = NULL)
        {
            $this->expectedToken = $expectedToken;
            $this->token = $token;
            $this->allTokens = $allTokens;
            $this->currentIdx = $currentIdx;
            $this->file = $filePath;

            parent::__construct($message ?? 'Expected different token', 0, $previous);
        }
    }
