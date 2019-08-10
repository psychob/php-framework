<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\ArgumentHintInterface;
    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\Generic\ImpliedBlockEndInterface;
    use PsychoB\Framework\Template\TemplateState;

    class ExtendsBlock implements BlockInterface, ImpliedBlockEndInterface, ArgumentHintInterface
    {
        public function getOutputType(): int
        {
            // TODO: Implement getOutputType() method.
        }

        public function execute(TemplateState $state): string
        {
            // TODO: Implement execute() method.
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }

        /** @inheritDoc */
        public static function metaGetImpliedEndOfBlock(): int
        {
            return self::IMPLIED_END_AT_BLOCK;
        }

        /** @inheritDoc */
        public static function getArguments(): array
        {
            return [
                'file' => self::ARG_REQUIRED | self::ARG_TYPE_PATH | self::ARG_PATH_TEMPLATES,
            ];
        }
    }
