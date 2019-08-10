<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    class RawHtmlBlock implements BlockInterface
    {
        /** @var string */
        protected $text;

        /**
         * RawHtmlBlock constructor.
         *
         * @param string $text
         */
        public function __construct(string $text)
        {
            $this->text = $text;
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML;
        }

        public function execute(TemplateState $state): string
        {
            return $this->text;
        }

        public function serialize(int $type): string
        {
            return $this->text;
        }
    }
