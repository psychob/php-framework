<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Application\App;
    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;
    use PsychoB\Framework\Utility\Arr;

    class AppConfigBlock implements BlockInterface
    {
        /** @var string[] */
        protected $config;

        /** @var mixed[] */
        protected $filters;

        /**
         * AppConfigBlock constructor.
         *
         * @param string[] $config
         * @param mixed[]  $filters
         */
        public function __construct(array $config, array $filters)
        {
            $this->config = $config;
            $this->filters = $filters;
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML | self::OUTPUT_HTML | self::OUTPUT_PHP;
        }

        public function execute(TemplateState $state): string
        {
            return config(Arr::implode($this->config, '.'));
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }

    }
