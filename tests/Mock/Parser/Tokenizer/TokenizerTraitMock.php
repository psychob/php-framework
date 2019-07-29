<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Tokenizer\TokenizerTrait;

    class TokenizerTraitMock
    {
        use TokenizerTrait;

        public function tokenize(string $content)
        {
            return $this->tokenizeImpl($content);
        }
    }
