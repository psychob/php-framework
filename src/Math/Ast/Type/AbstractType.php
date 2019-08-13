<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast\Type;

    use PsychoB\Framework\Math\Ast\AbstractExpr;
    use PsychoB\Framework\Math\Ast\Expr;
    use PsychoB\Framework\Math\Ast\TypeExpr;

    abstract class AbstractType extends AbstractExpr implements Expr, TypeExpr
    {
        /** @var string */
        protected $typeName;

        public function __construct(string $typeName, string $text, int $start, int $end)
        {
            parent::__construct($text, $start, $end);

            $this->typeName = $typeName;
        }

        public function getTypeName(): string
        {
            return $this->typeName;
        }

        public function getValue()
        {
            return $this->text;
        }
    }
