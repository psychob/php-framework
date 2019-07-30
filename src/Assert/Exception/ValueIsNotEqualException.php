<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Exception;

    use Throwable;

    class ValueIsNotEqualException extends AssertionException
    {
        /** @var mixed */
        protected $left;

        /** @var mixed */
        protected $right;

        /**
         * ValueIsNotEqualException constructor.
         *
         * @param mixed          $left
         * @param mixed          $right
         * @param string|null    $message
         * @param Throwable|null $previous
         */
        public function __construct($left, $right, ?string $message = NULL, Throwable $previous = NULL)
        {
            $this->left = $left;
            $this->right = $right;

            parent::__construct("is-equal", 'ValueIsNotEqualException', $message ?? 'Values are not equal', $previous);
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
