<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Parser\Tokenizer;
    use PsychoB\Framework\Parser\Tokens\KeywordToken;
    use PsychoB\Framework\Parser\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Transformers\StringTransformer;
    use PsychoB\Framework\Parser\Transformers\StripWhitespacesButNewLinesTransformer;
    use PsychoB\Framework\Router\Tokens\ExecutorToken;

    class RouteFileParser
    {
        /** @var Tokenizer */
        private $tokenizer;

        /**
         * RouteFileParser constructor.
         *
         * @param Tokenizer $tokenizer
         */
        public function __construct(Tokenizer $tokenizer)
        {
            $this->tokenizer = $tokenizer;
            $this->tokenizer->addGroup('symbols', ['"', ':', '@', ',', '{', '}', '->', '.'], SymbolToken::class, false);
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
            $currentIndent = 0;
            $lastInstruction = 0;

            for ($it = 0; $it < count($tokens); ++$it) {
                $current = $tokens[$it];

                // in root namespace all instructions should start with last instruction character
                Assert::isEqual($lastInstruction, $current->getStart());

                if ($current instanceof ExecutorToken) {
                    switch ($current->getToken()) {
                        case 'prefix':
                            $this->parsePrefix($tokens, $it, $currentIndent, $lastInstruction);
                            break;
                    }
                }
            }
        }

        protected function parsePrefix(array &$tokens, int &$it, int &$intend, int &$lastInstruction)
        {
            $current = $tokens[$it];

            Assert::typeRequirements($current, ExecutorToken::class, [
                'getToken' => 'prefix',
            ]);
        }
    }
