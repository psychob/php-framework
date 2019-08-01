<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Container;

    use Generator;
    use Iterator;

    abstract class AbstractCacheableGenerator implements Iterator
    {
        /** @var Iterator|null */
        protected $iterator = NULL;

        protected abstract function getGenerator(): Generator;

        public function current()
        {
            $this->ensureIteratorIsLoaded();

            return $this->iterator->current();
        }

        public function next()
        {
            $this->ensureIteratorIsLoaded();

            $this->iterator->next();
        }

        public function key()
        {
            $this->ensureIteratorIsLoaded();

            return $this->iterator->key();
        }

        public function valid()
        {
            $this->ensureIteratorIsLoaded();

            return $this->iterator->valid();
        }

        public function rewind()
        {
            $this->ensureIteratorIsLoaded();

            $this->iterator->rewind();
        }

        private function ensureIteratorIsLoaded(): void
        {
            if (!$this->iterator) {
                $this->iterator = new CacheableIterator($this->getGenerator());
            }
        }
    }
