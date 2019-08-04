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

        /**
         * TokenStream constructor.
         *
         * @param string $str
         * @param array  $groups
         */
        public function __construct(string $str, array $groups)
        {
            $this->str = $str;
            $this->groups = $groups;
        }

        protected function loadMoreContent(): ?string
        {
            $ret = NULL;
            [$this->str, $ret] = [$ret, $this->str];

            return $ret;
        }
    }
