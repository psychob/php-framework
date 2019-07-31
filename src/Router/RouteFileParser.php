<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\DependencyInjection\Resolver\Tag\ResolverNeverCache;
    use PsychoB\Framework\Parser\Tokenizer;
    use PsychoB\Framework\Parser\Tokens\KeywordToken;
    use PsychoB\Framework\Parser\Tokens\NewLineToken;
    use PsychoB\Framework\Parser\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Transformers\StringTransformer;
    use PsychoB\Framework\Parser\Transformers\StripWhitespacesButNewLinesTransformer;
    use PsychoB\Framework\Router\Tokens\ExecutorToken;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class RouteFileParser implements ResolverNeverCache
    {
        /** @var Tokenizer */
        private $tokenizer;

        /** @var mixed[] */
        protected $current = [];

        protected $routes = [];

        /**
         * RouteFileParser constructor.
         *
         * @param Tokenizer $tokenizer
         */
        public function __construct(Tokenizer $tokenizer)
        {
            $this->tokenizer = $tokenizer;
            $this->tokenizer->addGroup('symbols', ['"', ':', '@', ',', '{', '}', '->', '.', '::'], SymbolToken::class,
                false);
            $this->tokenizer->addGroup('keywords', ['GET', 'POST', 'PUT', 'OPTIONS', 'DELETE'], KeywordToken::class,
                false);
            $this->tokenizer->addGroup('executors', ['execute', 'view', 'prefix', 'middleware'], ExecutorToken::class,
                false);

            $this->tokenizer->addPass(StringTransformer::class);
            $this->tokenizer->addPass(StripWhitespacesButNewLinesTransformer::class);
        }

        public function parse(string $path)
        {
            $tokens = $this->tokenizer->tokenizeFile($path);

            $this->parseRoot(iterator_to_array($tokens));

            return $this->routes;
        }

        protected function parseRoot(array $tokens)
        {
            for ($it = 0; $it < count($tokens); ++$it) {
                $this->parseInstruction($tokens, $it);
            }
        }

        protected function parseInstruction(array &$tokens, int &$it, int $intend = 0): void
        {
            if ($tokens[$it] instanceof KeywordToken) {
                $this->parseRoute($tokens, $it, $intend);
            } else if ($tokens[$it] instanceof ExecutorToken) {
                $this->parseTree($tokens, $it, $intend);
            } else {
                throw new InvalidRouteInstructionException($tokens, $it);
            }
        }

        private function parseRoute(array &$tokens, int &$it, int $intend)
        {
            Assert::hasType($tokens[$it], KeywordToken::class);

            $methods = [$tokens[$it]->getToken()];
            $url = $tokens[$it + 1]->getToken();
            $execute = [];

            $it += 2;

            for (; $it < count($tokens); ++$it) {
                if (Validate::hasType($tokens[$it], NewLineToken::class)) {
                    break;
                }

                switch ($tokens[$it]->getToken()) {
                    case 'execute':
                        $execute = [
                            $tokens[$it + 1]->getToken(),
                            $tokens[$it + 2]->getToken(),
                            $tokens[$it + 3]->getToken(),
                        ];

                        $it += 3;
                        break;
                }
            }

            $this->pushRoute($methods, $url, $execute);
        }

        private function parseTree(array &$tokens, int &$it, int $intend)
        {
            Assert::hasType($tokens[$it], ExecutorToken::class);
            switch ($tokens[$it]->getToken()) {
                case 'prefix':
                    $this->parsePrefix($tokens, $it, $intend);
                    break;

                case 'middleware':
                    $this->parseMiddleware($tokens, $it, $intend);
                    break;

                default:
                    throw new \Exception();
            }

            Assert::typeRequirements($tokens[$it], NewLineToken::class, [
                'token' => PHP_EOL,
            ]);
            $end = $tokens[$it]->getEnd();
            $it++;

            $nextIntend = $tokens[$it]->getStart() - $end;
            if ($nextIntend > $intend) {
                $this->parseInstruction($tokens, $it, $nextIntend);
            } else {
                $this->pushCurrent($intend);
            }
        }

        protected function parsePrefix(array &$tokens, int &$it, int $intend)
        {
            Assert::typeRequirements($tokens[$it], ExecutorToken::class, [
                'token' => 'prefix',
            ]);
            $it++;
            $this->current[] = ['type' => 'prefix', 'name' => $tokens[$it]->getToken(), 'intend' => 0];

            $it++;
            Assert::typeRequirements($tokens[$it], SymbolToken::class, [
                'token' => ':',
            ]);

            $it++;
        }

        private function parseMiddleware(array &$tokens, int &$it, int $intend)
        {
            Assert::typeRequirements($tokens[$it], ExecutorToken::class, [
                'token' => 'middleware',
            ]);
            $it++;

            $middlewares = [];
            for (; count($tokens) > $it; ++$it) {
                if (Validate::typeRequirements($tokens[$it], SymbolToken::class, ['token' => ':',])) {
                    break;
                }

                if (Validate::typeRequirements($tokens[$it], SymbolToken::class, ['token' => ','])) {
                    continue;
                }

                $middlewares[] = $tokens[$it]->getToken();
            }

            $this->current[] = ['type' => 'middleware', 'middlewares' => $middlewares, 'indent' => $intend];
            $it++;
        }

        protected function pushRoute(array $methods, $url, array $execute): void
        {
            $route = [
                'methods' => $methods,
                'url' => $url,
                'execute' => $execute,
                'middlewares' => [],
            ];

            foreach (Arr::reverse($this->current) as $value) {
                switch ($value['type']) {
                    case 'prefix':
                        $route['url'] = $this->mergeUrl($value['name'], $route['url']);
                        break;

                    case 'middleware':
                        $route['middlewares'] = Arr::appendValues($route['middlewares'], $value['middlewares']);
                        break;
                }
            }

            $this->routes[] = new Route('', $route['url'], $route['methods'], $route['middlewares'], $route['execute']);
        }

        protected function mergeUrl($prefix, $url): string
        {
            if (Str::last($prefix) === '/' && Str::first($url) === '/') {
                return $prefix . Str::substr($url, 1);
            }

            return $prefix . $url;
        }

    }
