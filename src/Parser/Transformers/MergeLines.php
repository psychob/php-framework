<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Transformers;

    class MergeLines implements TransformerInterface
    {
        public function transform($iterable)
        {
            foreach ($iterable as $token) {
                yield $token;
            }
        }
    }
