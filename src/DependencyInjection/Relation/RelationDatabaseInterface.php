<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation;

    use PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition\Info;

    interface RelationDatabaseInterface
    {
        public function getArgumentListFor(string $class, string $method): ?Info;

        public function saveArgumentList(string $class, string $method, Info $arg);
    }
