<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Container\Exception;

    use Psr\Container\ContainerExceptionInterface;
    use PsychoB\Framework\Exception\BaseException;
    use Throwable;

    class ErrorRetrievingElementException extends BaseException implements ContainerExceptionInterface
    {
        /** @var mixed */
        protected $element;

        /**
         * ErrorRetrievingElementException constructor.
         *
         * @param mixed          $element
         * @param string         $message
         * @param Throwable|null $previous
         */
        public function __construct($element, string $message = '', ?Throwable $previous = NULL)
        {
            $this->element = $element;

            parent::__construct(sprintf('%s: Error while retrieving element: %s', $message, $element), 0, $previous);
        }

        /**
         * @return mixed
         */
        public function getElement()
        {
            return $this->element;
        }
    }
