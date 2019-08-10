<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http\Headers;

    class ContentTypeHeader implements HeaderInterface
    {
        use EmitHeaderTrait;

        const MIME_HTML   = 'text/html';
        const HEADER_NAME = 'Content-Type';

        /** @var string */
        protected $header;

        /** @var string */
        protected $value;

        /**
         * ContentTypeHeader constructor.
         *
         * @param string $header
         * @param string $value
         */
        public function __construct(string $header, string $value)
        {
            $this->header = $header;
            $this->value = $value;
        }

        public static function get(string $type): self
        {
            return new self(self::HEADER_NAME, $type);
        }

        public function getCanonicalName(): string
        {
            return self::HEADER_NAME;
        }

        public function getOriginalName(): string
        {
            return $this->header;
        }

        public function getOriginalValue(): string
        {
            return $this->value;
        }
    }
