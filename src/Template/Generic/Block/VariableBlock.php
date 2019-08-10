<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;
    use PsychoB\Framework\Utility\Arr;

    class VariableBlock implements BlockInterface
    {
        /** @var string */
        protected $name;

        /** @var string[] */
        protected $accessors;

        /** @var mixed[] */
        protected $filters;

        public function __construct(array $variable)
        {
            $this->name = $variable['name'];
            $this->accessors = $variable['accessors'];
            $this->filters = $variable['filters'];
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_HTML | self::OUTPUT_PHP | self::OUTPUT_RAW_HTML;
        }

        public function execute(TemplateState $state): string
        {
            return Arr::recursiveGet($state[$this->name], $this->accessors);
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }
    }
