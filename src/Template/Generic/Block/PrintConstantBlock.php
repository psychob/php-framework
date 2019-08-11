<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    class PrintConstantBlock implements BlockInterface
    {
        protected $constant;

        /**
         * PrintConstantBlock constructor.
         *
         * @param $constant
         */
        public function __construct($constant)
        {
            $this->constant = $constant;
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
            return self::IMPLIED_END_AT_INSTRUCTION;
        }

        public static function getHeaderPreference(): int
        {
            return self::PREFERENCE_ARGUMENTS;
        }

        public function execute(TemplateState $state): string
        {
            return $this->constant;
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }
    }
