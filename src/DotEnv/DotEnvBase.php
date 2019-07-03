<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DotEnv;

    /**
     * Base class for DotEnv Sources
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since 0.1
     */
    abstract class DotEnvBase implements DotEnvSourceInterface
    {
        /** @var bool */
        protected $volatile = false;

        /**
         * DotEnvBase constructor.
         *
         * @param bool $volatile
         */
        public function __construct(bool $volatile)
        {
            $this->volatile = $volatile;
        }

        /**
         * @inheritDoc
         */
        public function isVolatile(): bool
        {
            return $this->volatile;
        }
    }
