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
        public const OUTPUT_PHP      = 0b001;
        public const OUTPUT_HTML     = 0b010;
        public const OUTPUT_RAW_HTML = 0b100;

        public function getOutputType(): int;

        public function execute(TemplateState $state): string;

        public function serialize(int $type): string;
    }
