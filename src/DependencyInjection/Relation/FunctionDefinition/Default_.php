<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition;

    /**
     * Default
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Default_
    {
        /** @var bool */
        protected $has;

        /** @var mixed */
        protected $value;

        /**
         * Default_ constructor.
         *
         * @param bool  $has
         * @param mixed $value
         */
        public function __construct(bool $has, $value)
        {
            $this->has = $has;
            $this->value = $value;
        }

        /**
         * @return bool
         */
        public function isHas(): bool
        {
            return $this->has;
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }
    }
