<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http;

    use PsychoB\Framework\DependencyInjection\Injector\CustomInjectionInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Lookup\GetConfigValue;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class RequestFactory implements CustomInjectionInterface
    {
        protected $requestParsers = [];

        public static function __pbfw_injectHint(): array
        {
            return [
                '__construct' => [
                    'requestParsers' => new GetConfigValue('requests.header-parsers'),
                ],
            ];
        }

        /**
         * RequestFactory constructor.
         *
         * @param array $requestParsers
         */
        public function __construct(array $requestParsers)
        {
            $this->requestParsers = $requestParsers;
        }

        public function fromGlobals(): Request
        {
            $method = $_SERVER['REQUEST_METHOD'];
            $uri = $_SERVER['REQUEST_URI'];
            $headers = $this->fetchHeadersFromGlobal();
            $get = $this->fetchGetFromGlobal();
            $post = $this->fetchPostFromGlobal();

            return new Request($method, $uri, new ParameterContainer($headers), new ParameterContainer($get),
                               new ParameterContainer($post));
        }

        private function fetchHeadersFromGlobal(): array
        {
            $ret = [];

            foreach ($_SERVER as $header => $value) {
                if (Str::startsWith($header, 'HTTP_')) {
                    $header = Str::remove($header, 'HTTP_');
                    $header = Str::replace($header, '_', '-');
                    $header = Str::toLower($header);
                    $header = Str::upperCaseWords($header, '-');

                    if (Arr::has($this->requestParsers, $header)) {
                        $ret[] = new $this->requestParsers[$header]($header, $value);
                    } else {
                        $ret[] = new $this->requestParsers['*']($header, $value);
                    }

                }
            }

            return $ret;
        }

        private function fetchGetFromGlobal(): array
        {
            return $_GET;
        }

        private function fetchPostFromGlobal(): array
        {
            return $_POST;
        }
    }
