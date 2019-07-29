<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Transformers;

    use Mockery\MockInterface;
    use PsychoB\Framework\Parser\Tokenizer;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokens\NewLineToken;
    use PsychoB\Framework\Parser\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokens\TokenInterface;
    use PsychoB\Framework\Parser\Tokens\WhitespaceToken;
    use PsychoB\Framework\Parser\Transformers\StripWhitespacesButNewLinesTransformer;
    use PsychoB\Framework\Testing\Traits\EnableResolveInTestCaseTrait;
    use PsychoB\Framework\Testing\UnitTestCase;

    class StripWhitespacesButNewLinesTransformerTest extends UnitTestCase
    {
        use EnableResolveInTestCaseTrait;

        /** @var MockInterface|Tokenizer */
        private $tokenizer;

        protected function setUp(): void
        {
            parent::setUp();

            $this->tokenizer = $this->resolve(Tokenizer::class);
            $this->tokenizer->addPass(StripWhitespacesButNewLinesTransformer::class);
        }

        protected function verifyTokens(TokenInterface $exp, $cur, int $expIt, int $curIt)
        {
            $this->assertInstanceOf(TokenInterface::class, $cur);
            $this->assertSame(get_class($exp), get_class($cur), 'Type miss match with token: ' . $cur->getToken());

            $this->assertSame($exp->getToken(), $cur->getToken());
        }

        public function testRemovingWhitespaces()
        {
            $this->tokenizer->addGroup('symbols', ['(', ')', '$', '->', '-'], SymbolToken::class, false);

            $this->assertArrayElementsAre([
                new LiteralToken('func', 0, 0),
                new SymbolToken('(', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken(')', 0, 0),
                new SymbolToken('->', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken('-', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('b', 0, 0),
            ], $this->tokenizer->tokenize('func($x) -> $x - $b'), [$this, 'verifyTokens']);
        }

        public function testRemovingWhitespacesWithNewLines()
        {
            $this->tokenizer->addGroup('symbols', ['(', ')', '$', '->', '-'], SymbolToken::class, false);

            $this->assertArrayElementsAre([
                new LiteralToken('func', 0, 0),
                new SymbolToken('(', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken(')', 0, 0),
                new NewLineToken(PHP_EOL, 0, 0),
                new SymbolToken('->', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken('-', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('b', 0, 0),
            ], $this->tokenizer->tokenize("func(\$x)\n-> \$x - \$b"), [$this, 'verifyTokens']);
        }

        public function testRemovingWhitespacesWithNewLinesInsideWhitespaceTokens()
        {
            $this->tokenizer->addGroup('symbols', ['(', ')', '$', '->', '-'], SymbolToken::class, false);

            $this->assertArrayElementsAre([
                new LiteralToken('func', 0, 0),
                new SymbolToken('(', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken(')', 0, 0),
                new NewLineToken(PHP_EOL, 0, 0),
                new SymbolToken('->', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken('-', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('b', 0, 0),
            ], $this->tokenizer->tokenize("func(\$x) \n -> \$x - \$b"), [$this, 'verifyTokens']);
        }

        public function testRemovingWhitespacesWithMultipleNewLinesInsideWhitespaceTokens()
        {
            $this->tokenizer->addGroup('symbols', ['(', ')', '$', '->', '-'], SymbolToken::class, false);

            $this->assertArrayElementsAre([
                new LiteralToken('func', 0, 0),
                new SymbolToken('(', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken(')', 0, 0),
                new NewLineToken(PHP_EOL, 0, 0),
                new NewLineToken(PHP_EOL, 0, 0),
                new NewLineToken(PHP_EOL, 0, 0),
                new SymbolToken('->', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken('-', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('b', 0, 0),
            ], $this->tokenizer->tokenize("func(\$x) \n\n \n -> \$x - \$b"), [$this, 'verifyTokens']);
        }
    }
