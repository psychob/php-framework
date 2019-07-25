<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector;

    interface InjectorInterface
    {
        /**
         * Inject into $callable.
         *
         * @param callable $callable
         * @param array    $arguments
         *
         * @return mixed
         */
        public function inject($callable, array $arguments = []);

        /**
         * Make new instance of $class
         *
         * @param string $class
         * @param array  $arguments
         *
         * @return mixed
         */
        public function make(string $class, array $arguments = []);
    }
