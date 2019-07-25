<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector\Exception;

    use PsychoB\Framework\Exception\BaseException;
    use Throwable;

    class StaticCallNormalMethodException extends BaseException
    {
        /** @var string */
        protected $class;

        /** @var string */
        protected $method;

        /**
         * StaticCallNormalMethodException constructor.
         *
         * @param string         $class
         * @param string         $method
         * @param Throwable|null $previous
         */
        public function __construct(string $class, string $method, ?Throwable $previous = NULL)
        {
            $this->class = $class;
            $this->method = $method;

            parent::__construct(sprintf('Can not call %s::%s without object', $class, $method), 0, $previous);
        }

    }
