<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition;

    /**
     * Argument
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Argument
    {
        /** @var int */
        protected $no;

        /** @var string */
        protected $name;

        /** @var Type|null */
        protected $type;

        /** @var Default_ */
        protected $default;

        /** @var Wire|null */
        protected $wire;

        /**
         * Argument constructor.
         *
         * @param int       $no
         * @param string    $name
         * @param Type|null $type
         * @param Default_  $default
         * @param Wire|null $wire
         */
        public function __construct(int $no, string $name, ?Type $type, Default_ $default, ?Wire $wire)
        {
            $this->no = $no;
            $this->name = $name;
            $this->type = $type;
            $this->default = $default;
            $this->wire = $wire;
        }

        /**
         * @return int
         */
        public function getNo(): int
        {
            return $this->no;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @return Type|null
         */
        public function getType(): ?Type
        {
            return $this->type;
        }

        /**
         * @return Default_
         */
        public function getDefault(): Default_
        {
            return $this->default;
        }

        /**
         * @return Wire|null
         */
        public function getWire(): ?Wire
        {
            return $this->wire;
        }
    }
