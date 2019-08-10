<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    class NullBlock implements BlockInterface
    {
        public function getOutputType(): int
        {
            return self::OUTPUT_PHP;
        }

        public static function getArgumentTypeHint(): array
        {
            return [];
        }

        public static function getImpliedBlockEnd(): int
        {
            return self::IMPLIED_END_AT_INSTRUCTION;
        }

        public function execute(TemplateState $state): string
        {
            return '';
        }

        public function serialize(int $type): string
        {
            return '';
        }

        public static function getHeaderPreference(): int
        {
            return self::PREFERENCE_ARGUMENTS;
        }
    }
