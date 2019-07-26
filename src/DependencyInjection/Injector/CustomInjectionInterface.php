<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector;

    interface CustomInjectionInterface
    {
        public const PBFW_CUSTOM_INJECTION_METHOD = '__pbfw_injectHint';
        
        public static function __pbfw_injectHint(): array;
    }
