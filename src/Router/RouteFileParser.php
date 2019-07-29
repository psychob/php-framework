<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router;

    use PsychoB\Framework\Parser\Tokenizer;
    use PsychoB\Framework\Parser\Tokens\KeywordToken;
    use PsychoB\Framework\Parser\Tokens\SymbolToken;
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
            $this->tokenizer->addGroup('symbols', ['"', ':', '@', ',', '{', '->', '.'], SymbolToken::class, false);
            $this->tokenizer->addGroup('keywords', ['GET', 'POST', 'PUT', 'OPTIONS', 'DELETE'], KeywordToken::class, false);
            $this->tokenizer->addGroup('executors', ['execute', 'view'], ExecutorToken::class, false);
        }

        public function parse(string $path)
        {
            return iterator_to_array($this->tokenizer->tokenizeFile($path));
        }
    }
