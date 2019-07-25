<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\ErrorHandling\Render;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    trait ConsoleRenderTrait
    {
        public static function isConsole(): bool
        {
            return php_sapi_name() === 'cli';
        }

        protected static function consoleHandle(Throwable $t): void
        {
            $ret = static::consoleHandleThrowable($t);

            echo $ret;
        }

        protected static function consoleHandleThrowable(Throwable $t, int $intend = 0): string
        {
            $ret = sprintf('%s%s: %s%s', str_repeat(' ', $intend), static::consoleToType($t),
                           static::consoleString($t->getMessage()), PHP_EOL);
            $ret .= sprintf('%s at %s:%d%s', str_repeat(' ', $intend), $t->getFile(), $t->getLine(), PHP_EOL);
            $ret .= sprintf('%sStack Trace:%s', str_repeat(' ', $intend), PHP_EOL);

            $traceCount = count($t->getTrace());
            foreach ($t->getTrace() as $no => $trace) {
                $ret .= sprintf('%s % 3d. %s%s', str_repeat(' ', $intend),
                                $traceCount - $no, static::consoleHandleTrace($trace), PHP_EOL);
            }

            return $ret;
        }

        protected static function consoleHandleTrace(array $trace): string
        {
            $ret = '';
            $ret .= sprintf('%s%s%s()', $trace['class'] ?? '', $trace['type'] ?? '', $trace['function'] ?? 'anonymous');
            $ret .= sprintf(' at %s:%d', $trace['file'] ?? '<internal>', $trace['line']);

            return $ret;
        }

        protected static function consoleToType($obj): string
        {
            return static::consoleType(Str::toType($obj));
        }

        protected static function consoleType(string $type): string
        {
            return static::consoleColor(static::consoleGetRed(), $type);
        }

        protected static function consoleColor(string $color, string $msg): string
        {
            return sprintf('%s%s%s', $color, $msg, static::consoleGetResetColor());
        }

        protected static function consoleGetRed(): string
        {
            return "\e[31m";
        }

        protected static function consoleGetWhite(): string
        {
            return "\e[37m";
        }

        protected static function consoleGetResetColor(): string
        {
            return "\e[0m";
        }

        protected static function consoleString(string $str): string
        {
            return static::consoleColor(static::consoleGetWhite(), $str);
        }
    }
