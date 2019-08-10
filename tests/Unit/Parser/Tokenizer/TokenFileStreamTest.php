<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Tokenizer;

    use PsychoB\Framework\Testing\UnitTestCase;
    use Tests\PsychoB\Framework\Mock\Parser\Tokenizer\TokenFileStreamMock;

    class TokenFileStreamTest extends UnitTestCase
    {
        public function testEmptyFile()
        {
            $vfs = $this->prepareVirtualFileSystem([
                'file' => '',
            ]);

            $mock = new TokenFileStreamMock($vfs->url().'/file');

            $this->assertNull($mock->getMore());
            $this->assertNull($mock->getMore());
        }

        public function testOneChunk()
        {
            $vfs = $this->prepareVirtualFileSystem([
                'file' => 'a tokenizing file',
            ]);

            $mock = new TokenFileStreamMock($vfs->url().'/file');

            $this->assertSame('a tokenizing file', $mock->getMore());
            $this->assertNull($mock->getMore());
            $this->assertNull($mock->getMore());
        }

        public function testMultipleChunks()
        {
            $vfs = $this->prepareVirtualFileSystem([
                'file' => 'a tokenizing file',
            ]);

            $mock = new TokenFileStreamMock($vfs->url().'/file', 10);

            $this->assertSame('a tokenizi', $mock->getMore());
            $this->assertSame('ng file', $mock->getMore());
            $this->assertNull($mock->getMore());
            $this->assertNull($mock->getMore());
        }
    }
