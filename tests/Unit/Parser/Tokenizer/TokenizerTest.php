<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Tokenizer;

    use PsychoB\Framework\Exception\InvalidArgumentException;
    use PsychoB\Framework\Parser\Tokenizer\Tokenizer;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\LiteralToken;
    use PsychoB\Framework\Testing\UnitTestCase;

    class TokenizerTest extends UnitTestCase
    {
        public function testAddGroup(): void
        {
            $tokenizer = new Tokenizer();

            $tokenizer->addGroup('foo', ['bar'], LiteralToken::class, false);
            $this->assertTrue($tokenizer->hasGroup('foo'));
        }

        public function testAddGroupAlreadyExist(): void
        {
            $tokenizer = new Tokenizer();

            $tokenizer->addGroup('foo', ['bar'], LiteralToken::class, false);
            $this->assertTrue($tokenizer->hasGroup('foo'));

            $this->expectException(InvalidArgumentException::class);
            $tokenizer->addGroup('foo', ['bar'], LiteralToken::class, false);
        }

        public function testAddGroupDoesntImplementTokenInterface(): void
        {
            $tokenizer = new Tokenizer();

            $this->expectException(InvalidArgumentException::class);
            $tokenizer->addGroup('foo', ['bar'], TokenizerTest::class, false);
        }
    }
