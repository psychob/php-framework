<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Core\ErrorHandling;

    use PsychoB\Framework\Core\Exceptions\PHPErrorException;

    /**
     * Class DumbErrorHandler.
     *
     * This class is supposed to only rethrow old PHP Errors as Exception, so they can be processed later.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class DumbErrorHandler implements ErrorHandlerInterface
    {
        /** @inheritDoc */
        public function register(): void
        {
            set_error_handler([$this, 'handle']);
        }

        /**
         * This method throws exception so application could react in civilized way about old PHP Errors. This method
         * will almost always throw an exception.
         *
         * @param int    $level
         * @param string $message
         * @param string $file
         * @param int    $line
         *
         * @throws PHPErrorException
         */
        public function handle(int $level, string $message, string $file, int $line)
        {
            if (error_reporting() === 0) {
                // this means that this error is silenced by @ operator
                return;
            }

            throw new PHPErrorException($message, -1, $level, $file, $line);
        }
    }
