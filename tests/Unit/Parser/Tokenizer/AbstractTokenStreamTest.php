<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Tokenizer\Exception\UnexpectedCharacterException;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\NewLineToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\TokenInterface;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\WhitespaceToken;
    use PsychoB\Framework\Testing\Traits\TokenAssertTrait;
    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\Parser\Tokenizer\AbstractTokenStreamMock;

    class AbstractTokenStreamTest extends UnitTestCase
    {
        use TokenAssertTrait;

        public function testEmptyString()
        {
            $mock = \Mockery::mock(AbstractTokenStreamMock::class);
            $mock->makePartial()->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('loadMoreContent')->andReturn(NULL);

            $this->assertArrayIsEmpty($mock);
        }

        public function testOnlyLiterals()
        {
            $mock = \Mockery::mock(AbstractTokenStreamMock::class, [
                [
                    'literal' => [
                        'name' => 'literal',
                        'symbols' => [],
                        'class' => LiteralToken::class,
                        'allow_combining' => true,
                    ],
                ],
            ]);
            $mock->makePartial()->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('loadMoreContent')
                 ->andReturns('if tokenizer dosent know any group, it will put everything in literal group', NULL);

            $this->assertArrayElementsAre([new LiteralToken('if tokenizer dosent know any group, it will put everything in literal group'),],
                $mock, [$this, 'assertTokenTypeAndContent']);
        }

        public function testNOGroups()
        {
            $mock = \Mockery::mock(AbstractTokenStreamMock::class, []);
            $mock->makePartial()->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('loadMoreContent')
                 ->andReturns('if tokenizer dosent know any group, it will put everything in literal group', NULL);

            $this->expectException(UnexpectedCharacterException::class);

            $this->assertArrayElementsAre([new LiteralToken('if tokenizer dosent know any group, it will put everything in literal group'),],
                $mock, [$this, 'assertTokenTypeAndContent']);
        }

        public function testOnlyLiteralsPassedThroughMultipleLoadContent()
        {
            $mock = \Mockery::mock(AbstractTokenStreamMock::class, [
                [
                    'literal' => [
                        'name' => 'literal',
                        'symbols' => [],
                        'class' => LiteralToken::class,
                        'allow_combining' => true,
                    ],
                ],
            ]);
            $mock->makePartial()->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('loadMoreContent')
                 ->andReturns('if tokenizer dosent know any group, it will put everything in literal group',
                     'And it would make huge token', 'if you know what i mean', NULL);

            $this->assertArrayElementsAre([new LiteralToken('if tokenizer dosent know any group, it will put everything in literal groupAnd it would make huge tokenif you know what i mean'),],
                $mock, [$this, 'assertTokenTypeAndContent']);
        }

        public function testLiteralsWithWhitespaces()
        {
            $mock = \Mockery::mock(AbstractTokenStreamMock::class, [
                [
                    'literal' => [
                        'name' => 'literal',
                        'symbols' => [],
                        'class' => LiteralToken::class,
                        'allow_combining' => true,
                    ],
                    'whitespace' => [
                        'name' => 'whitespace',
                        'symbols' => [' ', "\t", "\r", "\v"],
                        'class' => WhitespaceToken::class,
                        'allow_combining' => true,
                    ],
                    'new_line' => [
                        'name' => 'whitespace',
                        'symbols' => ["\n"],
                        'class' => NewLineToken::class,
                        'allow_combining' => false,
                    ],
                ],
            ]);
            $mock->makePartial()->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('loadMoreContent')
                 ->andReturns('words for words' . PHP_EOL, 'foo bar' . PHP_EOL, NULL);

            $this->assertArrayElementsAre([
                new LiteralToken('words'),
                new WhitespaceToken(' '),
                new LiteralToken('for'),
                new WhitespaceToken(' '),
                new LiteralToken('words'),
                new NewLineToken(PHP_EOL),
                new LiteralToken('foo'),
                new WhitespaceToken(' '),
                new LiteralToken('bar'),
                new NewLineToken(PHP_EOL),
            ], $mock, [$this, 'assertTokenTypeAndContent']);
        }

        public function testLiteralsWithWhitespacesAndLocations()
        {
            $mock = \Mockery::mock(AbstractTokenStreamMock::class, [
                [
                    'literal' => [
                        'name' => 'literal',
                        'symbols' => [],
                        'class' => LiteralToken::class,
                        'allow_combining' => true,
                    ],
                    'whitespace' => [
                        'name' => 'whitespace',
                        'symbols' => [' ', "\t", "\r", "\v"],
                        'class' => WhitespaceToken::class,
                        'allow_combining' => true,
                    ],
                    'new_line' => [
                        'name' => 'whitespace',
                        'symbols' => ["\n"],
                        'class' => NewLineToken::class,
                        'allow_combining' => false,
                    ],
                ],
            ]);
            $mock->makePartial()->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('loadMoreContent')
                 ->andReturns('words for words' . PHP_EOL, 'foo bar' . PHP_EOL, NULL);

            $this->assertArrayElementsAre([
                new LiteralToken('words', 0, 5),
                new WhitespaceToken(' ', 5, 6),
                new LiteralToken('for', 6, 9),
                new WhitespaceToken(' ', 9, 10),
                new LiteralToken('words', 10, 15),
                new NewLineToken(PHP_EOL, 15, 16),
                new LiteralToken('foo', 16, 19),
                new WhitespaceToken(' ', 19, 20),
                new LiteralToken('bar', 20, 23),
                new NewLineToken(PHP_EOL, 23, 24),
            ], $mock, [$this, 'assertTokenTypeContentAndLocation']);
        }
    }
