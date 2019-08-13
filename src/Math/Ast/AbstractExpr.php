<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Math\Ast;

    abstract class AbstractExpr implements Expr
    {
        /** @var string */
        protected $text;

        /** @var int */
        protected $start;

        /** @var int */
        protected $end;

        /**
         * AbstractExpr constructor.
         *
         * @param string $text
         * @param int    $start
         * @param int    $end
         */
        public function __construct(string $text, int $start, int $end)
        {
            $this->text = $text;
            $this->start = $start;
            $this->end = $end;
        }

        /**
         * @return string
         */
        public function getText(): string
        {
            return $this->text;
        }

        /**
         * @return int
         */
        public function getStart(): int
        {
            return $this->start;
        }

        /**
         * @return int
         */
        public function getEnd(): int
        {
            return $this->end;
        }
    }
