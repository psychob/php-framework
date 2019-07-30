<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Exception;

    use Throwable;

    class InvalidArgumentException extends BaseException
    {
        /** @var string|null */
        protected $name;

        /** @var int|null */
        protected $position;

        /** @var string|null */
        protected $message;

        /** @var Throwable|null */
        protected $previous;

        /**
         * InvalidArgumentException constructor.
         *
         * @param string|null    $name
         * @param int|null       $position
         * @param string|null    $message
         * @param Throwable|null $previous
         */
        public function __construct(?string $name, ?int $position, ?string $message = NULL, ?Throwable $previous = NULL)
        {
            $this->name = $name;
            $this->position = $position;
            $this->message = $message;
            $this->previous = $previous;

            parent::__construct(sprintf('%s: Invalid argument at: %d named: %s', $message, $position, $name), 0,
                $previous);
        }
    }
