<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Template\Generic\Filter;

    use PsychoB\Framework\Template\Generic\FilterInterface;

    class RawFilter implements FilterInterface
    {
        public function supportsEmpty(): bool
        {
            return false;
        }

        public function executeEmpty(): array
        {
        }

        public function execute($variable): array
        {
            return [$variable, true, true];
        }
    }
