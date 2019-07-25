<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\ErrorHandling;

    use PsychoB\Framework\ErrorHandling\Render\ConsoleRenderTrait;
    use PsychoB\Framework\ErrorHandling\Render\HtmlRenderTrait;
    use Throwable;

    class DumbExceptionHandler
    {
        use ConsoleRenderTrait;
        use HtmlRenderTrait;

        public static function catch(Throwable $t): void
        {
            if (static::isConsole()) {
                static::consoleHandle($t);
            } else {
                static::handleWeb($t);
            }
        }
    }
