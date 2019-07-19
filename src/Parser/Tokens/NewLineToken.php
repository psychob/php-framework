<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokens;

    class NewLineToken extends WhiteSpaceToken
    {
        public function __construct(?DebugInfo $debug = NULL)
        {
            parent::__construct(PHP_EOL, $debug);
        }
    }
