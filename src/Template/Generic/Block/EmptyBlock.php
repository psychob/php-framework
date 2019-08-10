<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    class EmptyBlock implements BlockInterface
    {
        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML | self::OUTPUT_PHP | self::OUTPUT_HTML;
        }

        public function execute(TemplateState $state): string
        {
            return '';
        }

        public function serialize(int $type): string
        {
            return '';
        }
    }
