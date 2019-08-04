<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Tokenizer\TokenStream;

    class TokenStreamMock extends TokenStream
    {
        /**
         * TokenStreamMock constructor.
         *
         * @param $str
         */
        public function __construct($str)
        {
            $this->str = $str;
        }

        public function getMoreContent(): ?string
        {
            return parent::loadMoreContent();
        }
    }
