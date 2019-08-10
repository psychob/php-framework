<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Tokenizer;

    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\Parser\Tokenizer\TokenStreamMock;

    class TokenStreamTest extends UnitTestCase
    {
        public function testLoading()
        {
            $mock = new TokenStreamMock('abc');

            $this->assertSame('abc', $mock->getMoreContent());
            $this->assertNull($mock->getMoreContent());
            $this->assertNull($mock->getMoreContent());
        }
    }
