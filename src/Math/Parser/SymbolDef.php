<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Parser;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Math\Ast\Expr;

    class SymbolDef
    {
        public const TYPE_UNARY_PREFIX          = 0;
        public const TYPE_UNARY_POSTFIX         = 1;
        public const TYPE_BINARY_PREFIX         = 2;
        public const TYPE_BINARY_POSTFIX        = 3;
        public const TYPE_BINARY_PREFIX_POSTFIX = 4;

        /** @var string */
        protected $symbol;

        /** @var int */
        protected $type;

        /** @var string */
        protected $class;

        /**
         * SymbolDef constructor.
         *
         * @param string $symbol
         * @param int    $type
         * @param string $class
         */
        public function __construct(string $symbol, int $type, string $class)
        {
            Assert::arguments('Type must be one of SymbolDef::TYPE_ constants', 'type', 2)
                  ->enumOne($type, [
                      'SymbolDef::TYPE_UNARY_PREFIX' => SymbolDef::TYPE_UNARY_PREFIX,
                      'SymbolDef::TYPE_UNARY_POSTFIX' => SymbolDef::TYPE_UNARY_POSTFIX,
                      'SymbolDef::TYPE_BINARY_PREFIX' => SymbolDef::TYPE_BINARY_PREFIX,
                      'SymbolDef::TYPE_BINARY_POSTFIX' => SymbolDef::TYPE_BINARY_POSTFIX,
                      'SymbolDef::TYPE_BINARY_PREFIX_POSTFIX' => SymbolDef::TYPE_BINARY_PREFIX_POSTFIX,
                  ]);

            Assert::arguments('Class must implement Expr', 'class', 3)
                  ->classImplements($class, Expr::class);

            $this->symbol = $symbol;
            $this->type = $type;
            $this->class = $class;
        }

        /**
         * @return string
         */
        public function getSymbol(): string
        {
            return $this->symbol;
        }

        /**
         * @return int
         */
        public function getType(): int
        {
            return $this->type;
        }

        /**
         * @return string
         */
        public function getClass(): string
        {
            return $this->class;
        }
    }
