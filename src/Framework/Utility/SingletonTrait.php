<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Framework\Utility;

    /**
     * Trait SingletonTrait.
     *
     * @todo Add verify mechanism (if i ever finish it)
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     */
    trait SingletonTrait
    {
        /** @var self|null */
        protected static $Instance = NULL;

        /**
         * Make new instance of self, or return already existing one.
         *
         * @param mixed ...$args
         *
         * @return self
         */
        public static function make(...$args): self
        {
            if (static::$Instance === NULL) {
                static::$Instance = new self(...$args);
            }

            return static::$Instance;
        }

        /**
         * Clear already existing instance of self.
         *
         * @note Keep in mind, that because php keep track of object lifetime, clearing object here, might not
         *       cause to remove it, as all references to object must be cleared.
         */
        public static function clear(): void
        {
            if (static::$Instance !== NULL) {
                static::$Instance = NULL;
            }
        }
    }
