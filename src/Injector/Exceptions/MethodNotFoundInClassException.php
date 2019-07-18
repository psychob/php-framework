<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Exceptions;

    use Throwable;

    class MethodNotFoundInClassException extends CanNotInjectException
    {
        /** @var string */
        protected $class;

        /** @var string */
        protected $method;

        /**
         * MethodNotFoundInClassException constructor.
         *
         * @param string         $class
         * @param string         $method
         * @param Throwable|null $previous
         */
        public function __construct(string $class, string $method, ?Throwable $previous = NULL)
        {
            $this->class = $class;
            $this->method = $method;

            parent::__construct(sprintf('Method %s::%s not found', $class, $method), 0, $previous);
        }
    }
