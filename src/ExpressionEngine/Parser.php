<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\ExpressionEngine;

    use PsychoB\Framework\ExpressionEngine\Ast\NodeInterface;
    use PsychoB\Framework\ExpressionEngine\Parsers\ArrayParser;

    /**
     * Class Parser
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class Parser
    {
        /**
         * Parse string into AST
         *
         * @param string $input Input string
         *
         * @return NodeInterface
         * @throws ParseException When parses encounters unknown symbols
         */
        public static function parseString(string $input): NodeInterface
        {
            return (new StringParser($input))->parse();
        }

        /**
         * Parse array of strings into AST
         *
         * @param string[] $input
         *
         * @return NodeInterface
         * @throws ParseException When parser encounters unknown symbol
         */
        public static function parseArray(array $input): NodeInterface
        {
            return (new ArrayParser($input))->parse();
        }
    }
