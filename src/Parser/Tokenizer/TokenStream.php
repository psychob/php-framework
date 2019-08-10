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
         * @param array  $transformers
         */
        public function __construct(string $str, array $groups, array $transformers)
        {
            $this->str = $str;
            $this->groups = $groups;
            $this->transformers = $transformers;
        }

        protected function loadMoreContent(): ?string
        {
            $ret = NULL;
            [$this->str, $ret] = [$ret, $this->str];

            return $ret;
        }
    }
