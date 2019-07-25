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

    class InjectArgumentNotFoundException extends BaseException
    {
        /** @var int */
        protected $no;

        /** @var string */
        protected $name;

        /** @var callable */
        protected $method;

        /**
         * InjectArgumentNotFoundException constructor.
         *
         * @param int            $no
         * @param string         $name
         * @param callable       $method
         * @param Throwable|null $previous
         */
        public function __construct(int $no, string $name, $method, ?Throwable $previous = NULL)
        {
            $this->no = $no;
            $this->name = $name;
            $this->method = $method;

            parent::__construct(sprintf('Parameter: %s at position: %d can not be injected in callable: %s', $name, $no,
                                        Str::toRepr($method)), 0, $previous);
        }

        /**
         * @return int
         */
        public function getNo(): int
        {
            return $this->no;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @return callable
         */
        public function getMethod(): callable
        {
            return $this->method;
        }
    }
