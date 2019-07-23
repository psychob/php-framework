<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser;

    use Generator;
    use PsychoB\Framework\Parser\Tokenizer;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokens\Token;
    use PsychoB\Framework\Parser\Tokens\WhiteSpaceToken;
    use PsychoB\Framework\Testing\UnitTestCase;

    class TokenizerTest extends UnitTestCase
    {
        public function testEmptyTokenizer()
        {
            $tokenizer = new Tokenizer();
            $tokens = $tokenizer->tokenize('');

            $this->assertInstanceOf(Generator::class, $tokens);
            $this->assertArrayIsEmpty($tokens);
        }

        public function testWord()
        {
            $tokenizer = new Tokenizer();
            $tokens = $tokenizer->tokenize('word');

            $this->assertInstanceOf(Generator::class, $tokens);
            $this->assertArrayElementsAre([new LiteralToken('word'),], $tokens, function ($exp, $val) {
                $this->assertInstanceOf(get_class($exp), $val);
                /**
                 * @var Token $exp
                 * @var Token $val
                 */
                $this->assertSame($exp->getToken(), $val->getToken());
            });
        }

        public function testLine()
        {
            $tokenizer = new Tokenizer();
            $tokens = $tokenizer->tokenize('fnc (abc $def) -> gha { };');

            $this->assertInstanceOf(Generator::class, $tokens);
            $this->assertArrayElementsAre([
                                              new LiteralToken('fnc'),
                                              new WhiteSpaceToken(' '),
                                              new LiteralToken('(abc'),
                                              new WhiteSpaceToken(' '),
                                              new LiteralToken('$def)'),
                                              new WhiteSpaceToken(' '),
                                              new LiteralToken('->'),
                                              new WhiteSpaceToken(' '),
                                              new LiteralToken('gha'),
                                              new WhiteSpaceToken(' '),
                                              new LiteralToken('{'),
                                              new WhiteSpaceToken(' '),
                                              new LiteralToken('};'),
                                          ], $tokens, function ($exp, $val) {
                $this->assertInstanceOf(get_class($exp), $val);
                /**
                 * @var Token $exp
                 * @var Token $val
                 */
                $this->assertSame($exp->getToken(), $val->getToken());
            });
        }
    }
