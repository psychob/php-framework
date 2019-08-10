<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Tokenizer\TokenFileStream;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\LiteralToken;

    class TokenFileStreamMock extends TokenFileStream
    {
        public function __construct(string $fileName, ?int $fileChunk = NULL)
        {
            parent::__construct($fileName, [
                'literal' => [
                    'name' => 'literal',
                    'symbols' => [],
                    'class' => LiteralToken::class,
                    'allow_combining' => true,
                ],
            ], [], $fileChunk);
        }

        public function getMore(): ?string
        {
            return $this->loadMoreContent();
        }
    }
