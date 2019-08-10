<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    class EchoRawHtmlBlock implements BlockInterface
    {
        /** @var string */
        protected $txt;

        /**
         * EchoRawHtmlBlock constructor.
         *
         * @param string $txt
         */
        public function __construct(string $txt)
        {
            $this->txt = $txt;
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML;
        }

        public static function getArgumentTypeHint(): array
        {
            return [];
        }

        public static function getImpliedBlockEnd(): int
        {
            return self::IMPLIED_END_AT_BLOCK;
        }

        public function execute(TemplateState $state): string
        {
            return $this->txt;
        }

        public function serialize(int $type): string
        {
            return $this->txt;
        }
    }
