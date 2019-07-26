<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http\Headers;

    class GenericHeader implements HeaderInterface
    {
        /** @var string */
        protected $header;

        /** @var string */
        protected $value;

        public function __construct(string $header, string $value)
        {
            $this->header = $header;
            $this->value = $value;
        }

        public function getCanonicalName(): string
        {
            return $this->header;
        }

        public function getOriginalName(): string
        {
            return $this->getCanonicalName();
        }

        public function getOriginalValue(): string
        {
            return $this->value;
        }
    }
