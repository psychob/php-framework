<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer\Tokens;

    abstract class AbstractToken implements TokenInterface
    {
        /** @var string */
        protected $token;

        /** @var int */
        protected $rawStart, $rawEnd;

        /**
         * AbstractToken constructor.
         *
         * @param string $token
         * @param int    $rawStart
         * @param int    $rawEnd
         */
        public function __construct(string $token, int $rawStart = -1, int $rawEnd = -1)
        {
            $this->token = $token;
            $this->rawStart = $rawStart;
            $this->rawEnd = $rawEnd;
        }

        /** @inheritDoc */
        public function getToken(): string
        {
            return $this->token;
        }

        /** @inheritDoc */
        public function getStart(): int
        {
            return $this->rawStart;
        }

        /** @inheritDoc */
        public function getEnd(): int
        {
            return $this->rawEnd;
        }
    }
