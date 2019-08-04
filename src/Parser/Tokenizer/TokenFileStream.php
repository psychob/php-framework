<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer;

    class TokenFileStream extends AbstractTokenStream
    {
        protected $fileName;
        protected $filePointer = NULL;
        protected $fileChunk = 1024;
        protected $fileEof = false;

        protected function loadMoreContent(): ?string
        {
            if ($this->filePointer === NULL) {
                $this->filePointer = fopen($this->fileName, "rb");
            }

            if ($this->fileEof) {
                return NULL;
            }

            if (feof($this->filePointer)) {
                fclose($this->filePointer);
                $this->fileEof = true;

                return NULL;
            }

            $chunk = fread($this->filePointer, $this->fileChunk);

            return $chunk;
        }
    }
