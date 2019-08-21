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

    class ValuesAreDifferentException extends AssertionFailureException
    {
        /** @var mixed */
        private $left;

        /** @var mixed */
        private $right;

        /** @var bool */
        private $strict;

        /**
         * ValuesAreDifferentException constructor.
         *
         * @param mixed          $left
         * @param mixed          $right
         * @param string|null    $message
         * @param bool           $strict
         * @param Throwable|null $previous
         */
        public function __construct($left, $right, bool $strict, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            $this->left = $left;
            $this->right = $right;
            $this->strict = $strict;

            parent::__construct($strict ? 'is-same' : 'is-equal',
                sprintf('Value: %s is not %s to %s', Str::toRepr($left), $strict ? 'same' : 'equal',
                    Str::toRepr($right)), $message, -1, $previous);
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
