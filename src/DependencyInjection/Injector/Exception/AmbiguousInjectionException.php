<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector\Exception;

    use PsychoB\Framework\Exception\BaseException;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class AmbiguousInjectionException extends BaseException
    {
        /** @var int */
        protected $no;

        /** @var string */
        protected $name;

        /** @var callable */
        protected $method;

        /** @var mixed[] */
        protected $values;

        /**
         * AmbiguousInjectionException constructor.
         *
         * @param int            $no
         * @param string         $name
         * @param callable       $method
         * @param mixed[]        $values
         * @param Throwable|null $previous
         */
        public function __construct(int $no, string $name, $method, array $values, ?Throwable $previous = NULL)
        {
            $this->no = $no;
            $this->name = $name;
            $this->method = $method;
            $this->values = $values;

            parent::__construct(sprintf('Injection arguments are ambiguous for parameter %s (position: %d) in: %s',
                                        $name, $no, Str::toRepr($method)), 0, $previous);
        }
    }
