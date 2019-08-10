<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Container;

    use ArrayAccess;
    use PsychoB\Framework\Utility\Arr;

    /**
     * Trait ArrayContainerTrait
     *
     * @author Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
     * @since  0.1
     *
     * @mixin ArrayAccess
     */
    trait ArrayAccessTrait
    {
        /** @var mixed[] */
        protected $container = [];

        /** @inheritDoc */
        public function offsetExists($offset)
        {
            return Arr::has($this->container, $offset);
        }

        /** @inheritDoc */
        public function offsetGet($offset)
        {
            return $this->container[$offset];
        }

        /** @inheritDoc */
        public function offsetSet($offset, $value)
        {
            $this->container[$offset] = $value;
        }

        /** @inheritDoc */
        public function offsetUnset($offset)
        {
            unset($this->container[$offset]);
        }
    }
