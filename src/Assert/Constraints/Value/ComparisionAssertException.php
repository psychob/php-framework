<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\Value;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class ComparisionAssertException extends AssertionFailureException
    {
        /** @var mixed */
        protected $left;

        /** @var mixed */
        protected $right;

        /** @var bool */
        protected $strict;

        /**
         * ComparisionAssertException constructor.
         *
         * @param mixed          $left
         * @param mixed          $right
         * @param string         $word
         * @param bool           $strict
         * @param string         $assert
         * @param string|null    $customMessage
         * @param Throwable|null $previous
         */
        public function __construct($left,
            $right,
            string $word,
            bool $strict,
            string $assert,
            ?string $customMessage = NULL,
            ?Throwable $previous = NULL)
        {
            $this->left = $left;
            $this->right = $right;
            $this->strict = $strict;

            parent::__construct($assert,
                sprintf('Value: %s is %s: %s', Str::toRepr($left), $word, Str::toRepr($right)),
                $customMessage,
                -1,
                $previous);
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

        /**
         * @return bool
         */
        public function isStrict(): bool
        {
            return $this->strict;
        }
    }
