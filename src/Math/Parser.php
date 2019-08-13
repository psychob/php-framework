<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math;

    use Iterator;
    use PsychoB\Framework\Math\Ast\Expr;
    use PsychoB\Framework\Math\Ast\Group\Group;
    use PsychoB\Framework\Math\Ast\Op\AddOp;
    use PsychoB\Framework\Math\Ast\Symbol\Symbol;
    use PsychoB\Framework\Math\Ast\Type\FloatType;
    use PsychoB\Framework\Math\Ast\Type\IntType;
    use PsychoB\Framework\Math\Parser\SymbolDef;
    use PsychoB\Framework\Parser\Tokenizer\Tokenizer;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Utility\Str;

    class Parser
    {

        public static function parse(string $expr): Expr
        {
            $parser = new Parser();

            return $parser->expression($expr);
        }

        /** @var Tokenizer */
        protected $tokenizer;
        protected $symbols = [];

        public function __construct()
        {
            $this->tokenizer = new Tokenizer();
            $this->tokenizer->addGroup('symbols',
                ['+', '-', '*', '/', '(', ')'],
                SymbolToken::class,
                false
            );

            $this->tokenizer->addGroup('whitespaces',
                [' ', "\t", "\v", "\r", "\n"],
                WhitespaceToken::class,
                true
            );

            $this->setUpSymbols();

            dd($this);
        }

        private function setUpSymbols(): void
        {
            $this->symbols[] = new SymbolDef('+', SymbolDef::TYPE_UNARY_POSTFIX, UnaryPlus::class);
        }

        public function expression(string $expr): Expr
        {
            $tokens = $this->tokenizer->tokenize($expr);

            $tokens->rewind();

            return $this->getSubexpressionImpl($tokens);
        }

        private function getElement(Iterator $tokens): Expr
        {
            $current = NULL;
            while ($tokens->valid()) {
                $current = $tokens->current();

                if (!($current instanceof WhitespaceToken)) {
                    break;
                }

                $tokens->next();
            }

            if (!$tokens->valid()) {
                throw new ElementNotFoundException();
            }

            if ($current->getToken() === '-') {
                //
            }

            if ($current->getToken() === '(') {
                $tokens->next();

                return $this->getSubexpression($tokens, ')');
            }

            /// TODO: Function support

            if (Str::matching($current->getToken(), '/^[0-9]+$/')) {
                return new IntType($current->getToken(), $current->getStart(), $current->getEnd());
            }

            if (Str::matching($current->getToken(), '/^[0-9]+.[0-9]+$/')) {
                return new FloatType($current->getToken(), $current->getStart(), $current->getEnd());
            }

            return new Symbol($current->getToken(), $current->getStart(), $current->getEnd());
        }

        private function getSubexpression(Iterator $tokens, ?string $endChar = NULL): Expr
        {
            return new Group($this->getSubexpressionImpl($tokens, $endChar));
        }

        private function getSubexpressionImpl(Iterator $tokens, ?string $endChar = NULL): Expr
        {
            $lastGroup = $this->getOperand($tokens);

            while ($tokens->valid()) {
                $symbol = $this->getSymbol($tokens);
                $nextGroup = $this->getOperand($tokens);

                dump($lastGroup, $symbol, $nextGroup);
            }
        }

        private function getOperand(Iterator $tokens): Expr
        {
        }

        private function getSymbol(Iterator $tokens): Expr
        {
        }
    }
