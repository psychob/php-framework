<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast\Type;

    use PsychoB\Framework\Math\Ast\Expr;
    use PsychoB\Framework\Math\Ast\TypeExpr;

    class IntType extends AbstractType implements Expr, TypeExpr
    {
        public function __construct(string $text, int $start, int $end)
        {
            parent::__construct('int', $text, $start, $end);
        }
    }
