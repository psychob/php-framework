<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http\ResponseFailures;

    use PsychoB\Framework\Router\Exception\HttpException;
    use PsychoB\Framework\Router\Http\Request;
    use Throwable;

    class Http404 extends HttpException
    {
        public function __construct(Request $request, $message = "", Throwable $previous = NULL)
        {
            parent::__construct(404, $request, $message, $previous);
        }
    }
