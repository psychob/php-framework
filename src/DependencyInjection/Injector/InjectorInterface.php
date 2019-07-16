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
         * This method makes new $class with $arguments
         *
         * @param string $class
         * @param array  $arguments
         *
         * @return object
         */
        public function make(string $class, array $arguments = []);

        /**
         * This method injects into $callableOrClass
         *
         * @param array|string|callable $callableOrClass
         * @param array                 $arguments
         *
         * @return mixed
         */
        public function inject($callableOrClass, array $arguments = []);

        /**
         * This method returns function that - when executed - will return what $callableOrClass
         *
         * @param array|string|callable $callableOrClass
         * @param array                 $arguments
         *
         * @return callable
         */
        public function delegate($callableOrClass, array $arguments = []): callable;
    }
