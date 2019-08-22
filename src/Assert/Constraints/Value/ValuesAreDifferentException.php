<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Value;

    use Throwable;

    class ValuesAreDifferentException extends ComparisionAssertException
    {
        /**
         * ValueIsNotSmallerException constructor.
         *
         * @param mixed           $left
         * @param mixed           $right
         * @param bool            $strict
         * @param string|null     $message
         * @param \Throwable|null $previous
         */
        public function __construct($left, $right, bool $strict, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            parent::__construct($left, $right, 'not equal to', $strict, $strict ? 'is-same' : 'is-equal', $message,
                $previous);
        }
    }
