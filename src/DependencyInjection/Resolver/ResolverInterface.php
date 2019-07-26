<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Resolver;

    interface ResolverInterface
    {
        public function resolve(string $class, array $arguments = [], ?string $fromWhat = NULL);
    }
