<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition;

    /**
     * Wire
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Wire
    {
        /** @var bool */
        protected $isLiteral;

        /** @var string */
        protected $type;

        /** @var mixed */
        protected $literal;

        /**
         * Wire constructor.
         *
         * @param bool   $isLiteral
         * @param string $type
         * @param mixed  $literal
         */
        public function __construct(bool $isLiteral, string $type, $literal)
        {
            $this->isLiteral = $isLiteral;
            $this->type = $type;
            $this->literal = $literal;
        }

        /**
         * @return bool
         */
        public function isLiteral(): bool
        {
            return $this->isLiteral;
        }

        /**
         * @return string
         */
        public function getType(): string
        {
            return $this->type;
        }

        /**
         * @return mixed
         */
        public function getLiteral()
        {
            return $this->literal;
        }
    }
