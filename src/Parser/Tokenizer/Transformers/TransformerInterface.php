<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer\Transformers;

    interface TransformerInterface
    {
        /**
         * @param iterable $input
         *
         * @return iterable
         */
        public function transform($input);
    }
