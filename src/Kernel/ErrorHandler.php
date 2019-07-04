<?php
    //
    // psychob/ja
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Kernel;

    /**
     * ErrorHandler class.
     *
     * This class registers custom error handler, that rethrows PHP stupid "let's inform user about" Errors, to much
     * saner Exceptions.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    final class ErrorHandler
    {
        /**
         * Register ErrorHandler into PHP
         */
        public function register()
        {
            /// TODO: Add ability to catch Fatal Errors (PHP would still exit, but hey)
            set_error_handler([$this, 'throwException']);
        }

        /**
         * Simple trampoline, that ejects Error into Exceptions
         *
         * @param int    $level   Severity of Error
         * @param string $message Message associated with error
         * @param string $file    File where error occurred
         * @param int    $line    Line on which error occurred
         *
         * @throws \ErrorException
         */
        public function throwException(int $level, string $message, string $file, int $line)
        {
            /// TODO: Maybe rethrow NoticeException and stuff
            throw new \ErrorException($message, -1, $level, $file, $line);
        }
    }
