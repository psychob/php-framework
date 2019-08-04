<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mock\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Tokenizer\AbstractTokenStream;

    abstract class AbstractTokenStreamMock extends AbstractTokenStream
    {
        public function __construct(array $groups = [])
        {
            $this->groups = $groups;
        }
    }
