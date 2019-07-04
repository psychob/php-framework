<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Mocks\DotEnv\Sources;

    use PsychoB\Framework\DotEnv\Sources\ValueParserTrait;

    class ValueParserMock
    {
        use ValueParserTrait;

        public function parseVal($val)
        {
            return $this->parseValue($val);
        }
    }
