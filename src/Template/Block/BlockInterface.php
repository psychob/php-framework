<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Block;

    use PsychoB\Framework\Template\TemplateState;

    interface BlockInterface
    {
        public const OUTPUT_PHP      = 1;
        public const OUTPUT_HTML     = 2;
        public const OUTPUT_RAW_HTML = 3;

        public function getOutputType(): int;

        public function execute(TemplateState $state): string;

        public function serialize(): string;
    }
