<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\ExpressionEngine\Parsers;

    use PsychoB\Framework\ExpressionEngine\Ast\NodeInterface;

    class ArrayParser implements ParserInterface
    {
        /** @var string[] */
        protected $array;

        /**
         * ArrayParser constructor.
         *
         * @param string[] $array
         */
        public function __construct(array $array)
        {
            $this->array = $array;
        }

        public function parse(): NodeInterface
        {
            // TODO: Implement parse() method.
        }
    }
