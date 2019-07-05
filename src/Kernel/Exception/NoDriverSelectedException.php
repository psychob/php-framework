<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel\Exception;

    use PsychoB\Framework\Exceptions\LogicException;
    use Throwable;

    class NoDriverSelectedException extends LogicException
    {
        public function __construct($message = "", $code = 0, Throwable $previous = NULL)
        {
            if (empty($message)) {
                parent::__construct("No driver to select from", $code, $previous);
            } else {
                parent::__construct("No driver to select from: " . $message, $code, $previous);
            }
        }
    }
