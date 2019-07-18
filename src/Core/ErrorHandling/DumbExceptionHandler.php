<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Core\ErrorHandling;

    use Throwable;

    class DumbExceptionHandler implements ExceptionHandlerInterface
    {
        /** @inheritDoc */
        public function register(): void
        {
            set_exception_handler([$this, 'handle']);
        }

        /** @inheritDoc */
        public function handle(Throwable $t): void
        {
            if (php_sapi_name() !== 'cli' && env('APP_ENV') === 'production') {
                http_response_code(500);
                $this->print500();
                die;
            } else {
                if (php_sapi_name() === 'cli') {
                    echo $this->printConsoleException($t);
                } else {
                    http_response_code(500);
                    $output = htmlspecialchars($this->printConsoleException($t));
                    echo <<<HTML
<!doctype html>
<html>
<head>
<title>500 Internal Server Error</title>
</head>
<body>
<pre>{$output}</pre>
</body>
</html>
HTML;
                    die;
                }
            }
        }

        protected function print500(): void
        {
            echo <<<HTML
<!doctype html>
<html>
<head>
<title>HTTP 500</title>
</head>
<body>
<h1>HTTP 500</h1>
<hr />
<small>psychob/php-framework</small>
</body>
</html>
HTML;
        }

        protected function printConsoleException(Throwable $t, int $scope = 0): string
        {
            $ret = sprintf('%s%s: %s' . PHP_EOL, str_repeat(' ', $scope), get_class($t), $t->getMessage());
            $ret .= sprintf('%s at %s:%d' . PHP_EOL, str_repeat(' ', $scope), $t->getFile(), $t->getLine());
            $ret .= sprintf('%sStack:' . PHP_EOL, str_repeat(' ', $scope));

            $count = count($t->getTrace());
            foreach (($t->getTrace()) as $no => $trace) {
                $no = $count - $no;
                $ret .= sprintf('%s #%03d %s' . PHP_EOL, str_repeat(' ', $scope), $no, $this->serializeTrace($trace));
            }

            if ($t->getPrevious()) {
                $ret .= sprintf('%s Caused by:' . PHP_EOL, str_repeat(' ', $scope));
                $this->printConsoleException($t->getPrevious(), $scope + 1);
            }

            return $ret;
        }

        protected function serializeTrace(array $trace): string
        {
            $ret = sprintf('%s:%d %s%s%s(', $trace['file'] ?? '?', $trace['line'] ?? -1, $trace['class'], $trace['type'],
                           $trace['function']);

            foreach ($trace['args'] as $arg) {
                $ret .= $this->serializeValue($arg) . ', ';
            }

            $ret .= ')';

            return $ret;
        }

        protected function serializeValue($obj): string
        {
            if (is_array($obj)) {
                return $this->arrayToString($obj);
            }

            if (is_object($obj)) {
                return '<'.get_class($obj).'>';
            }

            if (is_string($obj)) {
                return sprintf('"%s"', $obj);
            }

            return $obj;
        }

        protected function arrayToString(array $obj)
        {
            if (empty($obj)) {
                return '[]';
            }

            if ($this->haveConsecutiveKeys($obj)) {
                return $this->simpleArrayToString($obj);
            } else {
                return $this->hashMapToString($obj);
            }

            dump($obj);
        }

        protected function haveConsecutiveKeys(array $obj): bool
        {
            reset($obj);
            $key = key($obj);

            if (!is_integer($key)) {
                return false;
            }

            for (next($obj); key($obj) !== NULL && current($obj) !== false; next($obj)) {
                $nextKey = key($obj);

                if (!is_integer($nextKey)) {
                    return false;
                }

                if ($nextKey - $key !== 1) {
                    return false;
                }

                $key = $nextKey;
            }

            return true;
        }

        protected function simpleArrayToString(array $arr)
        {
            $ret = '[';

            foreach ($arr as $value) {
                $ret .= $this->serializeValue($value) . ',';
            }

            return $ret . ']';
        }
    }
