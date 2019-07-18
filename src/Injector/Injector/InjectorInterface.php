<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Injector;

    interface InjectorInterface
    {
        /**
         * Inject into $object arguments supplied by $container and $arguments, and return returned value (new class,
         * or result of method)
         *
         * @param callable $object
         * @param array    $arguments
         *
         * @return mixed
         *
         * @throws CanNotInjectException When $object cant be injected. More information is present in previous
         *                               exception
         */
        public function inject($object, array $arguments = []);
    }
