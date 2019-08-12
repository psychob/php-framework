<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Block;

    use PsychoB\Framework\Template\Generic\BlockInterface;
    use PsychoB\Framework\Template\Generic\Builtin\Constant;
    use PsychoB\Framework\Template\Generic\Builtin\Group;
    use PsychoB\Framework\Template\Generic\Builtin\Tree;
    use PsychoB\Framework\Template\TemplateState;

    class PrintExpressionBlock implements BlockInterface
    {
        /** @var mixed */
        protected $instructions;

        /**
         * PrintExpressionBlock constructor.
         *
         * @param mixed[] $instructions
         */
        public function __construct($instructions)
        {
            $this->instructions = $instructions;
        }

        public function getOutputType(): int
        {
            return self::OUTPUT_RAW_HTML | self::OUTPUT_PHP;
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
            return htmlspecialchars($this->executeExpression($this->instructions, $state));
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }

        private function executeExpression($instructions, TemplateState $state): string
        {
            if ($instructions instanceof Group) {
                return $this->executeExpression($instructions->getGroup(), $state);
            }

            if ($instructions instanceof Tree) {
                $left = $instructions->getLeft();
                $sign = $instructions->getSign();
                $right = $instructions->getRight();

                if  ($left instanceof Group) {
                    $left = $this->executeExpression($left->getGroup(), $state);
                }

                if ($left instanceof Tree) {
                    $left = $this->executeExpression($left, $state);
                }

                if ($left instanceof Constant) {
                    $left = $left->getConstant();
                }

                if  ($right instanceof Group) {
                    $right = $this->executeExpression($right->getGroup(), $state);
                }

                if ($right instanceof Tree) {
                    $right = $this->executeExpression($right, $state);
                }

                if ($right instanceof Constant) {
                    $right = $right->getConstant();
                }

                switch ($sign) {
                    case '+':
                        return $left + $right;

                    case '-':
                        return $left - $right;

                    case '*':
                        return $left * $right;

                    case '/':
                        return $left / $right;
                }
            }

            return $instructions;
        }
    }
