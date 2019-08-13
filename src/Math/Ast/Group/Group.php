<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast\Group;

    use PsychoB\Framework\Math\Ast\AbstractExpr;
    use PsychoB\Framework\Math\Ast\Expr;
    use PsychoB\Framework\Math\Ast\GroupExpr;

    class Group extends AbstractExpr implements GroupExpr
    {
        /** @var Expr */
        private $expr;

        public function __construct(Expr $expr)
        {
            parent::__construct('', $expr->getStart(), $expr->getEnd());
            $this->expr = $expr;
        }

        public function getValue(): Expr
        {
            return $this->expr;
        }
    }
