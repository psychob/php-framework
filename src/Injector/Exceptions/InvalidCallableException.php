<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Exceptions;

    use PsychoB\Framework\Core\Utility\Str;
    use Throwable;

    class InvalidCallableException extends CanNotInjectException
    {
        /** @var mixed */
        protected $callable;

        /** @var mixed[] */
        protected $arguments;

        /**
         * InvalidCallableException constructor.
         *
         * @param string         $mesasge
         * @param mixed          $callable
         * @param mixed[]        $arguments
         * @param Throwable|null $previous
         */
        public function __construct(string $mesasge, $callable, array $arguments, ?Throwable $previous = null)
        {
            $this->callable = $callable;
            $this->arguments = $arguments;

            parent::__construct(sprintf('%s: Passed callable: %s(%s)', $mesasge, Str::toStr($callable),
                                        Str::toStr($arguments)), 0, $previous);
        }

        public static function unknownFormat($callable, array $arguments): InvalidCallableException
        {
            return new InvalidCallableException("Unknown format of callable", $callable, $arguments);
        }

        public static function invalidArrayFormat(array $callable, array $arguments): InvalidCallableException
        {
            return new InvalidCallableException("Invalid format of callable array", $callable, $arguments);
        }

        public static function invalidStringFormat(string $callable, array $arguments): InvalidCallableException
        {
            return new InvalidCallableException("Invalid format of callable string", $callable, $arguments);
        }
    }
