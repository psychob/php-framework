<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast;

    interface GroupExpr extends SymbolExpr
    {
        public function getLeft(): Expr;

        public function getRight(): Expr;
    }