<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Routes;

    use PsychoB\Framework\DependencyInjection\Resolver\Tag\ResolverNeverCache;
    use PsychoB\Framework\Router\Http\Request;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class RouteMatcher implements ResolverNeverCache
    {
        /** @var Route */
        private $route;

        /** @var int */
        private $counter = 0;

        public function __construct(Route $route)
        {
            $this->route = $route;
        }

        public function isMatched(Request $request): ?MatchedRoute
        {
            if (!Arr::contains($this->route->getMethods(), $request->getMethod())) {
                return NULL;
            }

            [$regularExpression, $named] = $this->makeRegExpFromUrl($this->route->getUrl());
            $matched = Str::match($request->getUrl(), $regularExpression);

            if ($matched === false) {
                return NULL;
            }

            /// TODO: Verify parameter types

            return new MatchedRoute($this->route, $matched);
        }

        private function makeRegExpFromUrl(string $url): array
        {
            $namedParameters = [];
            $parsedUrl = '';

            for ($it = 0; $it < Str::len($url); ++$it) {
                switch ($url[$it]) {
                    case '{':
                        [$partUrl, $namedParam, $paramType, $it] = $this->parseArgument($url, $it);
                        $parsedUrl .= $partUrl;
                        $namedParameters[$namedParam] = $paramType;
                        break;

                    case '/':
                        $parsedUrl .= '\/';
                        break;

                    default:
                        $parsedUrl .= $url[$it];
                        break;
                }
            }

            return ['/^' . $parsedUrl . '$/', $namedParameters];
        }

        private function parseArgument(string $url, int $it): array
        {
            $partUrl = null;
            $paramName = '';
            $paramType = 'str';
            $isType = false;

            for ($it++; $it < strlen($url); ++$it) {
                switch ($url[$it]) {
                    case ':':
                        $isType = true;
                        $paramType = '';
                        break;

                    case '}':
                        break 2;

                    default:
                        if ($isType) {
                            $paramType .= $url[$it];
                        } else {
                            $paramName .= $url[$it];
                        }
                }
            }

            switch ($paramType) {
                default:
                    $partUrl = sprintf('(?<%s>[^?\/]+)?', $paramName);
            }

            return [$partUrl, $paramName, $paramType, $it];
        }
    }
