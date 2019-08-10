<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Tokenizer\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokenizer\TokenStream;

    class TokenStreamMock extends TokenStream
    {
        public function __construct(string $str)
        {
            parent::__construct($str, [
                'literal' => [
                    'name' => 'literal',
                    'symbols' => [],
                    'class' => LiteralToken::class,
                    'allow_combining' => true,
                ],
            ], []);
        }

        public function getMoreContent(): ?string
        {
            return parent::loadMoreContent();
        }
    }
