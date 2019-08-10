<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Router\Http\Headers;

    /**
     * Trait EmitHeaderTrait
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @mixin HeaderInterface
     */
    trait EmitHeaderTrait
    {
        public function emit(): void
        {
            header($this->getCanonicalName() . ': ' . $this->getOriginalValue());
        }
    }
