<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast\Op;

    use PsychoB\Framework\Math\Ast\AbstractExpr;
    use PsychoB\Framework\Math\Ast\Expr;
    use PsychoB\Framework\Math\Ast\OpExpr;
    use PsychoB\Framework\Math\Ast\SymbolExpr;

    abstract class AbstractOp extends AbstractExpr implements Expr, SymbolExpr, OpExpr
    {
        protected $symbol;
        protected $left;
        protected $right;

        /**
         * AbstractGroup constructor.
         *
         * @param string $symbol
         * @param Expr   $left
         * @param Expr   $right
         */
        public function __construct(string $symbol, Expr $left, Expr $right)
        {
            parent::__construct('', min($left->getStart(), $right->getStart()),
                min($left->getEnd(), $right->getEnd()));

            $this->symbol = $symbol;
            $this->left = $left;
            $this->right = $right;
        }

        /**
         * @return Expr|SymbolExpr
         */
        public function getSymbol(): string
        {
            return $this->symbol;
        }

        /**
         * @return Expr
         */
        public function getLeft(): Expr
        {
            return $this->left;
        }

        /**
         * @return Expr
         */
        public function getRight(): Expr
        {
            return $this->right;
        }
    }
