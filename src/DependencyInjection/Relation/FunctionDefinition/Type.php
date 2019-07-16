<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition;

    /**
     * Type
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Type
    {
        /** @var string */
        protected $name;

        /** @var bool */
        protected $builtIn;

        /** @var bool */
        protected $allowsNull;

        /**
         * Type constructor.
         *
         * @param string $name
         * @param bool   $builtIn
         * @param bool   $allowsNull
         */
        public function __construct(string $name, bool $builtIn, bool $allowsNull)
        {
            $this->name = $name;
            $this->builtIn = $builtIn;
            $this->allowsNull = $allowsNull;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @return bool
         */
        public function isBuiltIn(): bool
        {
            return $this->builtIn;
        }

        /**
         * @return bool
         */
        public function isAllowsNull(): bool
        {
            return $this->allowsNull;
        }
    }
