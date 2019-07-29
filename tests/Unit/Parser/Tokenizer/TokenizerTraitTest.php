<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Tokenizer;

    use Mockery;
    use Mockery\MockInterface;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokens\TokenInterface;
    use PsychoB\Framework\Parser\Tokens\WhitespaceToken;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\Parser\Tokenizer\TokenizerTraitMock;

    class TokenizerTraitTest extends UnitTestCase
    {
        /** @var MockInterface|TokenizerTraitMock */
        private $tokenizer;

        protected function setUp(): void
        {
            parent::setUp();

            $this->tokenizer = Mockery::mock(TokenizerTraitMock::class)->makePartial();
        }

        protected function verifyTokens(TokenInterface $exp, $cur, int $expIt, int $curIt)
        {
            $this->assertInstanceOf(TokenInterface::class, $cur);
            $this->assertSame(get_class($exp), get_class($cur), 'Type miss match with token: '.$cur->getToken());

            $this->assertSame($exp->getToken(), $cur->getToken());
        }

        public function testEmptyString()
        {
            $this->assertArrayIsEmpty($this->tokenizer->tokenize(''));
        }

        public function testWords()
        {
            $this->assertArrayElementsAre([
                new LiteralToken('Eni', 0, 0),
                new WhitespaceToken(' ', 0, 0),
                new LiteralToken('Mini', 0, 0),
                new WhitespaceToken(' ', 0, 0),
                new LiteralToken('Mo', 0, 0)],
                $this->tokenizer->tokenize('Eni Mini Mo'), [$this, 'verifyTokens']);
        }

        public function testWhitespaceDefaultConfig()
        {
            $this->assertArrayElementsAre([
                new LiteralToken('Eni', 0, 0),
                new WhitespaceToken(" \t ", 0, 0),
                new LiteralToken('Mini', 0, 0),
                new WhitespaceToken(" \n\r ", 0, 0),
                new LiteralToken('Mo', 0, 0),
                new WhitespaceToken("\v", 0, 0),
            ], $this->tokenizer->tokenize("Eni \t Mini \n\r Mo\v"), [$this, 'verifyTokens']);
        }

        public function testSymbols()
        {
            $this->tokenizer->addGroup('symbols', ['(', ')', '$', '->', '-'], SymbolToken::class, false);

            $this->assertArrayElementsAre([
                new LiteralToken('func', 0, 0),
                new SymbolToken('(', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new SymbolToken(')', 0, 0),
                new WhitespaceToken(' ', 0, 0),
                new SymbolToken('->', 0, 0),
                new WhitespaceToken(' ', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('x', 0, 0),
                new WhitespaceToken(' ', 0, 0),
                new SymbolToken('-', 0, 0),
                new WhitespaceToken(' ', 0, 0),
                new SymbolToken('$', 0, 0),
                new LiteralToken('b', 0, 0),
            ], $this->tokenizer->tokenize('func($x) -> $x - $b'), [$this, 'verifyTokens']);
        }
    }
