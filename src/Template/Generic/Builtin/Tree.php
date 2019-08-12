<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Builtin;

    class Tree
    {
        protected $left;
        protected $sign;
        protected $right;

        /**
         * Tree constructor.
         *
         * @param $first
         * @param $sign
         * @param $second
         */
        public function __construct($first, $sign, $second)
        {
            $this->left = $first;
            $this->sign = $sign;
            $this->right = $second;
        }

        /**
         * @return mixed
         */
        public function getLeft()
        {
            return $this->left;
        }

        /**
         * @return mixed
         */
        public function getSign()
        {
            return $this->sign;
        }

        /**
         * @return mixed
         */
        public function getRight()
        {
            return $this->right;
        }
    }
