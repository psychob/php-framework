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

        public function execute(TemplateState $state): string
        {
            if (!empty($this->var->getFilters())) {
                return $this->executeWithFilters($state);
            } else {
                return $this->executeWithoutFilters($state);
            }
        }

        public function serialize(int $type): string
        {
            // TODO: Implement serialize() method.
        }

        private function executeWithFilters(TemplateState $state): string
        {
            [$value, $has] = Arr::recursiveGet($state, $this->var->getAccessors(), NULL, true);
            $raw = false;

            foreach ($this->var->getFilters() as $filter) {
                $f = $state->getFilter($filter['name']);

                if (!$has) {
                    if ($f->supportsEmpty()) {
                        [$value, $has, $raw] = $f->executeEmpty();
                    } else {
                        throw new EmptyValueException();
                    }
                } else {
                    [$value, $has, $raw] = $f->execute($value);
                }
            }

            if ($raw) {
                return $value;
            } else {
                return htmlspecialchars($value);
            }
        }

        private function executeWithoutFilters(TemplateState $state): string
        {
            return htmlspecialchars(Arr::recursiveGet($state, $this->var->getAccessors()));
        }

        public static function getHeaderPreference(): int
        {
            return self::PREFERENCE_ARGUMENTS;
        }
    }
