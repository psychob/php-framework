<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Tokenizer\TokenFileStream;

    class TokenFileStreamMock extends TokenFileStream
    {
        /**
         * TokenFileStreamMock constructor.
         *
         * @param string $fileName
         * @param int    $fileChunk
         */
        public function __construct(string $fileName, int $fileChunk = 10 * 1024)
        {
            $this->fileName = $fileName;
            $this->fileChunk = $fileChunk;
        }

        public function getMore(): ?string
        {
            return $this->loadMoreContent();
        }
    }
