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
    use PsychoB\Framework\Math\Ast\OpExpr;
    use PsychoB\Framework\Math\Ast\Op\AddGroup;
    use PsychoB\Framework\Math\Ast\Op\DivGroup;
    use PsychoB\Framework\Math\Ast\Op\MulGroup;
    use PsychoB\Framework\Math\Ast\Op\SubGroup;
    use PsychoB\Framework\Math\Ast\Symbol\Symbol;
    use PsychoB\Framework\Math\Ast\Type\FloatType;
    use PsychoB\Framework\Math\Ast\Type\IntType;
    use PsychoB\Framework\Parser\Tokenizer\Tokenizer;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Utility\Arr;
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

        protected $precedenceDefault = 0;
        protected $precedence = [
            '+' => 0,
            '-' => 0,
            '*' => 10,
            '/' => 10,
        ];

        protected $symbols = [
            '+' => AddGroup::class,
            '-' => SubGroup::class,
            '/' => DivGroup::class,
            '*' => MulGroup::class,
        ];

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

        private function getSubexpressionImpl(Iterator $tokens, ?string $endChar = null): Expr
        {
            while ($tokens->valid()) {
                $el = $this->getElement($tokens);
                $elements[] = $el;

                $tokens->next();

                if ($endChar !== NULL && ($el instanceof Symbol && $el->getSymbol() === $endChar)) {
                    break;
                }
            }

            if (Arr::len($elements) === 1) {
                return Arr::first($elements);
            }

            // build expr
            $e = [];
            foreach ($elements as $element) {
                switch (Arr::len($e)) {
                    case 2:
                        $class = $e[1]->getSymbol();
                        $class = $this->symbols[$class];

                        if ($e[0] instanceof OpExpr) {
                            $symbol = $e[0]->getSymbol();
                            $leftPrec = $this->precedence[$symbol] ?? $this->precedenceDefault;
                            $rightPrec = $this->precedence[$e[1]->getSymbol()] ?? $this->precedenceDefault;

                            if ($rightPrec > $leftPrec) {
                                // we change places
                                $right = new $class($e[0]->getRight(), $element);
                                $leftClass = new $this->symbols[$e[0]->getSymbol()]($e[0]->getLeft(), $right);

                                $e = [$leftClass,];
                            } else {
                                // we are doing normal thing
                                $e = [new $class($e[0], $element),];
                            }
                        } else {
                            $e = [
                                new $class($e[0], $element),
                            ];
                        }
                        continue;

                    default:
                        Arr::push($e, $element);
                }
            }

            return Arr::first($e);
        }
    }
