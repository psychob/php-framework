<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\ErrorHandling\Render;

    use PsychoB\Framework\Utility\Str;
    use Throwable;

    trait HtmlRenderTrait
    {
        protected static function handleWeb(Throwable $t): void
        {
            http_response_code(500);

            if (env('APP_ENV', 'production') === 'local') {
                // more detailed
                $ret = '';

                $ret .= static::webPrologue();
                $ret .= static::webOutputBody($t);
                $ret .= static::webEpilogue();

                echo $ret;
            } else {
                // only error
                echo <<<HTML
<!doctype html>
<html>
<head>
<title>Internal Server Error</title>
<style type="text/css">
body {
    margin: 0 auto; 
    width: 998px;
}
div {
    padding: 15px;
    line-height: 2em;
    font-size: 14pt;
}
footer, h1 {
    text-align: center;
}
code {
    background-color: #684c9c;
    color: #f9f871;
    padding: 5px;
    font-family: "Source Code Pro", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}
</style>
</head>
<body style="">
<h1>Internal Server Error</h1>
<div>
You are seeing this page, because your application is not properly configured or your environment is failing. To 
verify where errors occur use those commands:
<ul>
<li><code>framework verify config</code> - to verify if you have proper configuration</li>
<li><code>framework verify middleware</code> - to verify if one of your middlewares fails when processing request</li>
</ul>
</div>
<div>
If you expected to see error information, please change environment variable <code>APP_ENV</code> to <code>local</code>.
Full error information should be in log file.
</div>
<footer>
psychob/framework
</footer>
</body>
</html>
HTML;
            }

            exit(1);
        }

        protected static function webPrologue(): string
        {
            return <<<HTML
<!doctype html>
<html>
<head>
<title>500 HTTP</title>
<style type="text/css">
body {
    margin: 0 auto; 
    width: 998px;
}
div {
    padding: 15px;
    line-height: 2em;
    font-size: 14pt;
}
footer, h1 {
    text-align: center;
}
code {
    background-color: #684c9c;
    color: #f9f871;
    padding: 5px;
    font-family: "Source Code Pro", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}
.stack {
    font-family: "Source Code Pro", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}
.stack .function {
    font-weight: bolder;
}
ol li:nth-of-type(2n) {
    background-color: #eee;
}
ol li:hover {
    background-color: #ddd;
}
</style>
<body>
<h1>Internal Server Error</h1>
HTML;
        }

        protected static function webOutputBody(Throwable $t): string
        {
            $it = 0;
            $ret = '';

            while ($t !== NULL) {
                $ret .= '<div class="exception">';
                $ret .= static::webHandleThrowable($t);

                if ($t->getPrevious()) {
                    $ret .= sprintf('%sCaused by:%s', str_repeat(' ', $it), PHP_EOL);
                }

                $t = $t->getPrevious();
                $it++;
            }

            while ($it-- > 0) {
                $ret .= '</div>';
            }

            return $ret;
        }

        protected static function webEpilogue(): string
        {
            return <<<HTML
<footer>
psychob/framework
</footer>
</body>
</html>
HTML;
        }

        protected static function webHandleThrowable(Throwable $t): string
        {
            $ret = sprintf('<header><span class="type">%s</span>: <span class="message">%s</span></header>',
                           Str::toType($t), Str::escapeHtml($t->getMessage()));

            $ret .= sprintf('<div class="stack">at <span class="file">%s</span>:<span class="line">%d</span></div>',
                            $t->getFile(), $t->getLine());

            $ret .= '<ol reversed="reversed">';
            foreach ($t->getTrace() as $no => $trace) {
                $ret .= sprintf('<li class="stack"><span class="class">%s</span><span class="type">%s</span><span class="function">%s</span>()',
                                Str::escapeHtml($trace['class'] ?? ''), Str::escapeHtml($trace['type'] ?? ''),
                                Str::escapeHtml($trace['function'] ?? '<internal>'));
                $ret .= sprintf(' at <span class="file">%s</span>:<span class="line">%d</span></li>',
                                Str::escapeHtml($trace['file'] ?? '<internal>'), Str::escapeHtml($trace['line'] ?? -1));
            }
            $ret .= '</ol>';

            return $ret;
        }
    }
