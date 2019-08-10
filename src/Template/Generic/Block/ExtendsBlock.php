<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\TemplateState;

    class ExtendsBlock implements BlockInterface
    {
        public function getOutputType(): int
        {
            return self::OUTPUT_PHP;
        }

        public static function getArgumentTypeHint(): array
        {
            return [
                'file' => self::ARG_REQUIRED | self::ARG_PATH_TEMPLATE,
            ];
        }

        public static function getImpliedBlockEnd(): int
        {
            return self::IMPLIED_END_AT_BLOCK;
        }

        public function execute(TemplateState $state): string
        {
            // TODO: Implement execute() method.
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }
    }
