<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Routes\Loader;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Assert\Constraints\TypeAssert;
    use PsychoB\Framework\Assert\Validate;
    use PsychoB\Framework\Config\ConfigManagerInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\Tag\ResolverNeverCache;
    use PsychoB\Framework\Parser\Tokenizer;
    use PsychoB\Framework\Parser\Tokens\KeywordToken;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokens\NewLineToken;
    use PsychoB\Framework\Parser\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokens\TokenInterface;
    use PsychoB\Framework\Parser\Transformers\StringTransformer;
    use PsychoB\Framework\Parser\Transformers\StripWhitespacesButNewLinesTransformer;
    use PsychoB\Framework\Router\Routes\Loader\Tokens\ExecutorToken;
    use PsychoB\Framework\Router\Routes\Route;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;

    class RouteFileLoader implements ResolverNeverCache
    {
        /** @var Tokenizer */
        private $tokenizer;

        /** @var mixed[] */
        protected $current = [];

        /** @var Route[] */
        protected $routes = [];

        /** @var string */
        protected $file;

        /** @var string[] */
        protected $allowedMethods = [];

        /** @var string[] */
        protected $allowedExecutors = ['execute', 'view', 'prefix', 'middleware', 'name'];

        /**
         * RouteFileParser constructor.
         *
         * @param Tokenizer              $tokenizer
         * @param ConfigManagerInterface $config
         * @param string                 $path
         */
        public function __construct(Tokenizer $tokenizer, ConfigManagerInterface $config, string $path)
        {
            $this->allowedMethods = $config->get('routes.methods', []);

            $this->tokenizer = $tokenizer;
            $this->tokenizer->addGroup('symbols', ['"', ':', ',', '->', '::'], SymbolToken::class, false);
            $this->tokenizer->addGroup('keywords', $this->allowedMethods, KeywordToken::class, false);
            $this->tokenizer->addGroup('executors', $this->allowedExecutors, ExecutorToken::class, false);

            $this->tokenizer->addPass(StringTransformer::class);
            $this->tokenizer->addPass(StripWhitespacesButNewLinesTransformer::class);

            $this->file = $path;
        }

        public function parse()
        {
            $tokens = $this->tokenizer->tokenizeFile($this->file);
            $this->parseRoot(iterator_to_array($tokens));

            return $this->routes;
        }

        protected function parseRoot(array $tokens)
        {
            for ($it = 0; $it < count($tokens); ++$it) {
                $it = $this->parseInstruction($tokens, $it);
            }
        }

        protected function parseInstruction(array &$tokens, int $it, int $intend = 0): int
        {
            if ($tokens[$it] instanceof KeywordToken) {
                $it = $this->parseRoute($tokens, $it, $intend);
            } else if ($tokens[$it] instanceof ExecutorToken) {
                $it = $this->parseTree($tokens, $it, $intend);
            } else {
                throw new InvalidRouteInstructionException($tokens, $it);
            }

            return $it;
        }

        protected function parseRoute(array &$tokens, int $it, int $intend)
        {
            $this->assertType(KeywordToken::class, $tokens[$it], $tokens, $it);

            $methods = [$tokens[$it]->getToken()];
            $url = $tokens[$it + 1]->getToken();
            $execute = [];
            $name = NULL;
            $view = NULL;

            $it += 2;

            for (; $it < count($tokens); ++$it) {
                if (Validate::hasType($tokens[$it], NewLineToken::class)) {
                    break;
                }

                $this->assertType(ExecutorToken::class, $tokens[$it], $tokens, $it);

                switch ($tokens[$it]->getToken()) {
                    case 'execute':
                        $this->assertType(LiteralToken::class, $tokens[$it + 1], $tokens, $it + 1);
                        $this->assertType(SymbolToken::class, $tokens[$it + 2], $tokens, $it + 2);
                        $this->assertType(LiteralToken::class, $tokens[$it + 3], $tokens, $it + 3);

                        $execute = [
                            $tokens[$it + 1]->getToken(),
                            $tokens[$it + 2]->getToken(),
                            $tokens[$it + 3]->getToken(),
                        ];

                        $it += 3;
                        break;

                    case 'name':
                        $name = $tokens[$it + 1]->getToken();
                        $it += 1;
                        break;

                    case 'view':
                        $view = $tokens[$it + 1]->getToken();
                        $it += 1;
                        break;

                    default:
                        $this->unknownExceutor($tokens[$it]->getToken(), $tokens[$it], $tokens, $it);
                }
            }
            $this->pushRoute($methods, $url, $execute, $name, $view);

            return $it;
        }

        private function parseTree(array &$tokens, int $it, int $intend)
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
                $it = $this->parseInstruction($tokens, $it, $nextIntend);
            } else {
                $this->pushCurrent($intend);
            }

            return $it;
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

        protected function pushRoute(array $methods, $url, array $execute, ?string $name, ?string $view): void
        {
            $route = [
                'methods' => $methods,
                'url' => $url,
                'execute' => $execute,
                'middlewares' => [],
                'name' => $name,
                'view' => $view,
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

            $this->routes[] = new Route($route['name'] ?? sprintf('anonymous_%s',
                    hash('sha256', implode('-', $route['methods']) . $route['url'])),
                $route['url'], $route['methods'], $route['middlewares'], $route['execute'],
                $route['view']);
        }

        protected function mergeUrl($prefix, $url): string
        {
            if (Str::last($prefix) === '/' && Str::first($url) === '/') {
                return $prefix . Str::substr($url, 1);
            }

            return $prefix . $url;
        }

        protected function assertType($element, TokenInterface $currentToken, array $tokens, int $idx): void
        {
            Assert::hasType($element, [TypeAssert::TYPE_STRING, TypeAssert::TYPE_ARRAY]);

            if (Str::is($element)) {
                if (!Validate::hasType($currentToken, $element)) {
                    throw new InvalidTokenException($element, $currentToken, $tokens, $idx);
                }

                return;
            }

            Assert::unreachable();
        }
    }
