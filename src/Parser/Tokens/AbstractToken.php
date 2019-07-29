<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokens;

    abstract class AbstractToken implements TokenInterface
    {
        /** @var string */
        protected $token;

        /** @var int */
        protected $startIt;

        /** @var int */
        protected $endIt;

        /**
         * AbstractToken constructor.
         *
         * @param string $token
         * @param int    $startIt
         * @param int    $endIt
         */
        public function __construct(string $token, int $startIt, int $endIt)
        {
            $this->token = $token;
            $this->startIt = $startIt;
            $this->endIt = $endIt;
        }

        public function getToken(): string
        {
            return $this->token;
        }

        public static function fromRange(array $tokens): self
        {
            $tok = '';
            $start = $tokens[0]->startIt;
            $end = $tokens[0]->endIt;

            /** @var AbstractToken $token */
            foreach ($tokens as $token) {
                $tok .= $token->token;
                $start = min($start, $token->startIt);
                $end = max($end, $token->endIt);
            }

            return new static($tok, $start, $end);
        }

        public function getStart(): int
        {
            return $this->startIt;
        }

        public function getEnd(): int
        {
            return $this->endIt;
        }
    }
