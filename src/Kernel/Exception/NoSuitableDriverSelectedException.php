<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel\Exception;

    use PsychoB\Framework\Exceptions\LogicException;
    use Throwable;

    class NoSuitableDriverSelectedException extends LogicException
    {
        /** @var array */
        protected $selected = [];

        /** @var int */
        protected $limit = -1;

        /**
         * NoSuitableDriverSelectedException constructor.
         *
         * @param array          $selected
         * @param int            $limit
         * @param Throwable|null $previous
         */
        public function __construct(array $selected, int $limit, ?Throwable $previous = NULL)
        {
            $this->selected = $selected;
            $this->limit = $limit;

            parent::__construct(sprintf('Did not found any suitable driver, driver with highest level is: %s with %s',
                                        implode(', ', $selected), $limit), 0, $previous);
        }

    }
