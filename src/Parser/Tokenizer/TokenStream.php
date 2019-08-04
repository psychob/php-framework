<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer;

    class TokenStream extends AbstractTokenStream
    {
        protected $str;

        protected function loadMoreContent(): ?string
        {
            $ret = NULL;
            [$this->str, $ret] = [$ret, $this->str];

            return $ret;
        }
    }
