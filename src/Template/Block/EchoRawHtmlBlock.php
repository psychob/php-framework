<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Block;

    use PsychoB\Framework\Template\TemplateState;

    class EchoRawHtmlBlock implements BlockInterface
    {
        /** @var string */
        protected $content;

        /**
         * EchoRawHtmlBlock constructor.
         *
         * @param string $content
         */
        public function __construct(string $content)
        {
            $this->content = $content;
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML;
        }

        public function execute(TemplateState $state): string
        {
            return $this->content;
        }

        public function serialize(): string
        {
        }
    }
