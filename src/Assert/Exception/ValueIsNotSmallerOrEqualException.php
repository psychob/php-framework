<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class ValueIsNotSmallerOrEqualException extends AssertionException
    {
        protected $left;
        protected $right;

        /**
         * ValueIsNotGreaterOrEqualException constructor.
         *
         * @param                 $left
         * @param                 $right
         * @param string|null     $message
         * @param Throwable|null  $p
         */
        public function __construct($left, $right, string $message = NULL, Throwable $p = NULL)
        {
            $this->left = $left;
            $this->right = $right;

            parent::__construct($left, 'is-smaller-equal', 'Value: ' . $left . ' is not smaller or equal to ' . $right,
                $message, $p);
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
        public function getRight()
        {
            return $this->right;
        }
    }
