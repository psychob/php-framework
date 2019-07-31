<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Exception;

    use PsychoB\Framework\Exception\BaseException;
    use PsychoB\Framework\Router\Http\Request;
    use Throwable;

    class HttpException extends BaseException
    {
        protected $httpCode;
        protected $request;

        public function __construct(int $code, Request $request, $message = "", Throwable $previous = NULL)
        {
            $this->httpCode = $code;
            $this->request = $request;

            parent::__construct($message, 0, $previous);
        }
    }
