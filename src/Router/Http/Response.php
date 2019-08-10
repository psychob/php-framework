<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http;

    class Response
    {
        /** @var mixed[] */
        protected $headers;

        /** @var string|array */
        protected $body;

        /** @var int */
        protected $status = 200;

        /**
         * Response constructor.
         *
         * @param mixed[]      $headers
         * @param array|string $body
         * @param int          $status
         */
        public function __construct($body, array $headers = [], int $status = 200)
        {
            $this->headers = $headers;
            $this->body = $body;
            $this->status = $status;
        }

        /**
         * @return mixed[]
         */
        public function getHeaders(): array
        {
            return $this->headers;
        }

        /**
         * @return array|string
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @return int
         */
        public function getStatus(): int
        {
            return $this->status;
        }

        public function hasContentType(): bool
        {
            return false;
        }
    }
