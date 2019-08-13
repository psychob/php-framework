<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast\Op;

    use PsychoB\Framework\Math\Ast\Expr;

    class MulGroup extends AbstractOp implements Expr
    {
        public function __construct(Expr $left, Expr $right)
        {
            parent::__construct('*', $left, $right);
        }
    }
