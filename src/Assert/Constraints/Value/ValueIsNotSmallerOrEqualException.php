<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Value;

    class ValueIsNotSmallerOrEqualException extends ComparisionAssertException
    {
        /**
         * ValueIsNotSmallerException constructor.
         *
         * @param mixed           $left
         * @param mixed           $right
         * @param string|null     $message
         * @param \Throwable|null $previous
         */
        public function __construct($left, $right, ?string $message = NULL, \Throwable $previous = NULL)
        {
            parent::__construct($left, $right, 'not smaller or equal to', false, 'is-smaller-equal', $message, $previous);
        }
    }
