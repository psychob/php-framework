<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Block;

    use PsychoB\Framework\Template\TemplateState;
    use PsychoB\Framework\Utility\Arr;

    class PrintVariableBlock implements BlockInterface
    {
        /** @var string */
        protected $varName;

        /** @var mixed[] */
        protected $accessors;

        /** @var mixed[] */
        protected $filters;

        /**
         * PrintVariableBlock constructor.
         *
         * @param string $varName
         * @param array  $accessors
         * @param array  $filters
         */
        public function __construct(string $varName, array $accessors = [], array $filters = [])
        {
            $this->varName = $varName;
            $this->accessors = $accessors;
            $this->filters = $filters;
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML;
        }

        public function execute(TemplateState $state): string
        {
            if (!empty($this->filters)) {
                $tmp = Arr::recursiveGet($state[$this->varName], $this->accessors);
                $isRaw = false;

                foreach ($this->filters as $filter) {
                    if ($filter['name'] === 'raw') {
                        $isRaw = true;
                    }
                }

                if ($isRaw) {
                    return $tmp;
                } else {
                    return htmlspecialchars($tmp);
                }
            } else {
                return htmlspecialchars(Arr::recursiveGet($state[$this->varName], $this->accessors));
            }
        }

        public function serialize(): string
        {
            // TODO: Implement serialize() method.
        }
    }
