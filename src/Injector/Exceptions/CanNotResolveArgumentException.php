<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Exceptions;

    use Throwable;

    class CanNotResolveArgumentException extends CanNotInjectException
    {
        /** @var string */
        protected $class;

        /** @var string */
        protected $function;

        /** @var string */
        protected $name;

        /** @var int */
        protected $no;

        /**
         * CanNotResolveArgumentException constructor.
         *
         * @param string          $class
         * @param string          $function
         * @param string          $name
         * @param int             $no
         * @param Throwable|null $previous
         */
        public function __construct(string $class,
                                    string $function,
                                    string $name,
                                    int $no,
                                    ?Throwable $previous = NULL)
        {
            $this->class = $class;
            $this->function = $function;
            $this->name = $name;
            $this->no = $no;

            parent::__construct(sprintf('Function: %s argument %d (named: %s) can not be resolved',
                                        $this->class . '::' . $this->function, $no, $name), 0, $previous);
        }

    }
