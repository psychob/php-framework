<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast\Symbol;

    use PsychoB\Framework\Math\Ast\AbstractExpr;
    use PsychoB\Framework\Math\Ast\Expr;
    use PsychoB\Framework\Math\Ast\SymbolExpr;

    class Symbol extends AbstractExpr implements Expr, SymbolExpr
    {
        public function __construct(string $text, int $start, int $end)
        {
            parent::__construct($text, $start, $end);
        }

        /**
         * @return string
         */
        public function getSymbol(): string
        {
            return $this->text;
        }
    }
