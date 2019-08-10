<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\Generic\Builtin\Variable;
    use PsychoB\Framework\Template\TemplateState;
    use PsychoB\Framework\Utility\Arr;

    class PrintVariableBlock implements BlockInterface
    {
        /** @var Variable */
        protected $var;

        /**
         * PrintVariableBlock constructor.
         *
         * @param Variable $accessors
         */
        public function __construct(Variable $accessors)
        {
            $this->var = $accessors;
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML | self::OUTPUT_HTML | self::OUTPUT_PHP;
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
            return Arr::recursiveGet($state, $this->var->getAccessors());
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }
    }
