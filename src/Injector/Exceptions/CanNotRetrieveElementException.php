<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Exceptions;

    use Psr\Container\ContainerExceptionInterface;
    use RuntimeException;

    class CanNotRetrieveElementException extends RuntimeException implements ContainerExceptionInterface
    {
        protected $key;

        /**
         * CanNotRetrieveElementException constructor.
         *
         * @param mixed           $id
         * @param \Throwable|null $previous
         */
        public function __construct($id, ?\Throwable $previous = NULL)
        {
            $this->key = $id;

            parent::__construct(sprintf("Can not retrieve element: %s", $id), 0, $previous);
        }

        /**
         * @return mixed
         */
        public function getKey()
        {
            return $this->key;
        }

    }
