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

    }
