<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    class IfBlock implements BlockInterface
    {
        public function getOutputType(): int
        {
            // TODO: Implement getOutputType() method.
        }

        public static function getArgumentTypeHint(): array
        {
            // TODO: Implement getArgumentTypeHint() method.
        }

        public static function getImpliedBlockEnd(): int
        {
            // TODO: Implement getImpliedBlockEnd() method.
        }

        public function execute(TemplateState $state): string
        {
            // TODO: Implement execute() method.
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }

        public static function getHeaderPreference(): int
        {
            return self::PREFERENCE_TOKENS;
        }
    }
