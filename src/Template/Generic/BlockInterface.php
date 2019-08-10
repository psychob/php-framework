<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic;

    use PsychoB\Framework\Template\TemplateState;

    interface BlockInterface
    {
        /** @var int Output content as PHP */
        public const OUTPUT_PHP = 0b001;

        /** @var int Output content as HTML (it will be escaped) */
        public const OUTPUT_HTML = 0b010;

        /** @var int Output content as Raw HTML (it won't be escaped) */
        public const OUTPUT_RAW_HTML = 0b100;

        public function getOutputType(): int;

        public static function getArgumentTypeHint(): array;

        public const IMPLIED_END_AT_INSTRUCTION = 0;
        public const IMPLIED_END_AT_BLOCK       = 1;

        public static function getImpliedBlockEnd(): int;

        public function execute(TemplateState $state): string;

        public function serialize(int $type): string;
    }
