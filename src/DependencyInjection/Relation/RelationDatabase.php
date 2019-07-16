<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation;

    use PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition\Info;

    /**
     * RelationDatabase class.
     *
     * This class holds metadata about classes and thier methods to speed up injection process. It also contain
     * definitions for what should be supplied it class based on configurations.
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    class RelationDatabase implements RelationDatabaseInterface
    {
        /** @var mixed[][] */
        protected $classMap = [];

        /** @inheritDoc */
        public function getArgumentListFor(string $class, string $method): ?Info
        {
            return null;
        }

        /** @inheritDoc */
        public function saveArgumentList(string $class, string $method, Info $arg)
        {
            return null;
        }
    }
