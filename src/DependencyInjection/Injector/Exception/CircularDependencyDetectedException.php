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

    class CircularDependencyDetectedException extends BaseException
    {
        /** @var string */
        protected $class;

        /** @var string[] */
        protected $trail;

        /**
         * CircularDependencyDetectedException constructor.
         *
         * @param string         $class
         * @param string[]       $trail
         * @param Throwable|null $previous
         */
        public function __construct(string $class, array $trail, ?Throwable $previous = NULL)
        {
            $this->class = $class;
            $this->trail = $trail;

            parent::__construct(sprintf('Circular dependency detected at: %s with trail: %s', $class,
                                        Str::toRepr($trail)), 0, $previous);
        }

    }
