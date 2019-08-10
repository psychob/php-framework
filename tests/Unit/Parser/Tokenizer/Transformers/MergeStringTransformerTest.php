<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Tokenizer\Transformers;

    use PsychoB\Framework\Parser\Tokenizer\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\NewLineToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\StringToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Parser\Tokenizer\Transformers\MergeIntoStringTransformer;
    use PsychoB\Framework\Testing\Traits\TokenAssertTrait;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\Parser\Tokenizer\AbstractTokenStreamMock;

    class MergeStringTransformerTest extends UnitTestCase
    {
        use TokenAssertTrait;

        /** @var \Mockery\MockInterface|AbstractTokenStreamMock */
        protected $mock;

        protected function setUp(): void
        {
            parent::setUp();

            $this->mock = \Mockery::mock(AbstractTokenStreamMock::class, [
                [
                    'literal' => [
                        'name' => 'literal',
                        'symbols' => [],
                        'class' => LiteralToken::class,
                        'allow_combining' => true,
                    ],
                    'symbol' => [
                        'name' => 'symbol',
                        'symbols' => ['"', '\\'],
                        'class' => SymbolToken::class,
                        'allow_combining' => false,
                    ],
                    'whitespace' => [
                        'name' => 'whitespace',
                        'symbols' => [' ', "\t", "\r", "\v", "\n"],
                        'class' => WhitespaceToken::class,
                        'allow_combining' => true,
                    ],
                ],
                [
                    new MergeIntoStringTransformer(),
                ],
            ]);
            $this->mock->makePartial()->shouldAllowMockingProtectedMethods();
        }

        public function testSingleString()
        {
            $this->mock->shouldReceive('loadMoreContent')
                       ->andReturns('My "loveable" valentine', NULL);

            $this->assertArrayElementsAre([
                new LiteralToken('My', 0, 2),
                new WhitespaceToken(' ', 2, 3),
                new StringToken('loveable', 3, 13),
                new WhitespaceToken(' ', 13, 14),
                new LiteralToken('valentine', 14, 23),
            ], $this->mock, [$this, 'assertTokenTypeContentAndLocation']);
        }

        public function testSingleStringMultipleTokens()
        {
            $this->mock->shouldReceive('loadMoreContent')
                       ->andReturns('My "loveable fuck" valentine', NULL);

            $this->assertArrayElementsAre([
                new LiteralToken('My', 0, 2),
                new WhitespaceToken(' ', 2, 3),
                new StringToken('loveable fuck', 3, 18),
                new WhitespaceToken(' ', 18, 19),
                new LiteralToken('valentine', 19, 28),
            ], $this->mock, [$this, 'assertTokenTypeContentAndLocation']);
        }

        public function testZeroString()
        {
            $this->mock->shouldReceive('loadMoreContent')
                       ->andReturns('My "" valentine', NULL);

            $this->assertArrayElementsAre([
                new LiteralToken('My', 0, 2),
                new WhitespaceToken(' ', 2, 3),
                new StringToken('', 3, 5),
                new WhitespaceToken(' ', 5, 6),
                new LiteralToken('valentine', 6, 15),
            ], $this->mock, [$this, 'assertTokenTypeContentAndLocation']);
        }

        public function testEscapedString()
        {
            $this->mock->shouldReceive('loadMoreContent')
                       ->andReturns('My "sexy \"" valentine', NULL);

            $this->assertArrayElementsAre([
                new LiteralToken('My', 0, 2),
                new WhitespaceToken(' ', 2, 3),
                new StringToken('sexy "', 3, 12),
                new WhitespaceToken(' ', 12, 13),
                new LiteralToken('valentine', 13, 22),
            ], $this->mock, [$this, 'assertTokenTypeContentAndLocation']);
        }
    }
