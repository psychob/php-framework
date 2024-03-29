<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector\Lookup;

    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;

    interface ArgumentLookupInterface
    {
        public function resolve(ResolverInterface $resolver);
    }
