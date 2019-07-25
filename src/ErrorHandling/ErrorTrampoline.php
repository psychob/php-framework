<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\ErrorHandling;

    use PsychoB\Framework\Exception\PHPErrorException;

    class ErrorTrampoline
    {
        public static function eject(int $level, string $message, string $file, int $line): void
        {
            if (error_reporting() === 0) {
                // this means that this error is silenced by @ operator
                return;
            }

            throw new PHPErrorException($message, -1, $level, $file, $line);
        }

        public static function shutdown()
        {
            $lastError = error_get_last();

            if ($lastError !== NULL) {
                $e = new PHPErrorException($lastError['message'], -1, $lastError['type'], $lastError['file'],
                                           $lastError['line']);

                DumbExceptionHandler::catch($e);
                error_clear_last();
            }
        }
    }
