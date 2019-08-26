<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\ExpressionEngine\Parsers;

    use PsychoB\Framework\ExpressionEngine\Ast\NodeInterface;

    interface ParserInterface
    {
        /**
         * Parse content of parser into AST
         *
         * @return NodeInterface
         * @throws ParseException When parser encounters unknown symbol
         */
        public function parse(): NodeInterface;
    }
