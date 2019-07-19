<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokens;

    class Token
    {
        /** @var string */
        protected $token;

        /** @var null */
        protected $debug;

        /**
         * Token constructor.
         *
         * @param string         $token
         * @param DebugInfo|null $debug
         */
        public function __construct(string $token, ?DebugInfo $debug = NULL)
        {
            $this->token = $token;
            $this->debug = $debug;
        }

        /**
         * @return string
         */
        public function getToken(): string
        {
            return $this->token;
        }

        /**
         * @return null
         */
        public function getDebug()
        {
            return $this->debug;
        }
    }
