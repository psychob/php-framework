<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition;

    /**
     * Info
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Info
    {
        /** @var string|null */
        protected $className;

        /** @var string|null */
        protected $methodName;

        /** @var Argument[] */
        protected $arguments = [];

        /** @var int[int] */
        protected $posToIdx = [];

        /** @var int[string] */
        protected $nameToIdx = [];

        /**
         * Info constructor.
         *
         * @param string|null $className
         * @param string|null $methodName
         * @param Argument[]  $arguments
         * @param int[]       $posToIdx
         * @param int[string] $nameToIdx
         */
        public function __construct(?string $className,
                                    ?string $methodName,
                                    array $arguments,
                                    array $posToIdx,
                                    array $nameToIdx)
        {
            $this->className = $className;
            $this->methodName = $methodName;
            $this->arguments = $arguments;
            $this->posToIdx = $posToIdx;
            $this->nameToIdx = $nameToIdx;
        }

        /**
         * @return string|null
         */
        public function getClassName(): ?string
        {
            return $this->className;
        }

        /**
         * @return string|null
         */
        public function getMethodName(): ?string
        {
            return $this->methodName;
        }

        /**
         * @return Argument[]
         */
        public function getArguments(): array
        {
            return $this->arguments;
        }

        public function iterate(): iterable
        {
            foreach ($this->posToIdx as $no => $idx) {
                yield $this->arguments[$idx];
            }
        }
    }
