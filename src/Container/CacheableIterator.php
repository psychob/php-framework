<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Container;

    use Iterator;
    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\Utility\Arr;

    class CacheableIterator implements Iterator
    {
        private const STATE_EMPTY    = 0;
        private const STATE_RUNNING  = 1;
        private const STATE_PAUSED   = 2;
        private const STATE_FINISHED = 3;

        /** @var Iterator */
        private $internalIterator = NULL;

        /** @var mixed */
        private $container = [];

        /** @var integer */
        private $insideIterator = 0;

        /** @var integer */
        private $outsideIterator = 0;

        /** @var int */
        private $state = self::STATE_EMPTY;

        /**
         * CacheableIterator constructor. It assumes that $iterator is currently at position 0
         *
         * @param Iterator $iterator
         */
        public function __construct(Iterator $iterator)
        {
            $this->internalIterator = $iterator;
        }

        /** @inheritDoc */
        public function current()
        {
            switch ($this->state) {
                case self::STATE_EMPTY:
                case self::STATE_RUNNING:
                    return $this->internalIterator->current();

                case self::STATE_PAUSED:
                case self::STATE_FINISHED:
                    return $this->container[$this->outsideIterator][1];

                default:
                    Assert::unreachable('Iterator state not supported in current');
            }
        }

        /** @inheritDoc */
        public function next()
        {
            switch ($this->state) {
                case self::STATE_RUNNING:
                    $this->insideIterator++;
                    $this->internalIterator->next();
                    break;

                case self::STATE_FINISHED:
                case self::STATE_PAUSED:
                    $this->outsideIterator++;
                    break;

                default:
                    Assert::unreachable('Iterator state not supported in next');
            }
        }

        /** @inheritDoc */
        public function key()
        {
            switch ($this->state) {
                case self::STATE_RUNNING:
                    return $this->internalIterator->key();

                case self::STATE_FINISHED:
                case self::STATE_PAUSED:
                    return $this->container[$this->outsideIterator][0];

                default:
                    Assert::unreachable('Iterator state not supported in key');
            }
        }

        /** @inheritDoc */
        public function valid()
        {
            $isValid = $this->internalIterator->valid();

            switch ($this->state) {
                case self::STATE_RUNNING:
                    if (!$isValid) {
                        // we finished running, we can go home now
                        $this->state = self::STATE_FINISHED;
                    } else {
                        $this->container[$this->insideIterator] = [
                            $this->internalIterator->key(),
                            $this->internalIterator->current(),
                        ];
                    }

                    return $isValid;

                case self::STATE_FINISHED:
                    return Arr::has($this->container, $this->outsideIterator);

                case self::STATE_PAUSED:
                    if ($this->outsideIterator === $this->insideIterator) {
                        $this->state = self::STATE_RUNNING;

                        return $this->valid();
                    } else {
                        return Arr::has($this->container, $this->outsideIterator);
                    }

                default:
                    Assert::unreachable('Iterator state not supported in valid');
            }
        }

        /** @inheritDoc */
        public function rewind()
        {
            switch ($this->state) {
                case self::STATE_EMPTY:
                    $this->internalIterator->rewind();
                    $this->state = self::STATE_RUNNING;
                    break;

                case self::STATE_FINISHED:
                    $this->outsideIterator = 0;
                    break;

                case self::STATE_RUNNING:
                    $this->outsideIterator = 0;
                    $this->state = self::STATE_PAUSED;
                    break;

                default:
                    Assert::unreachable('Iterator state not supported in rewind');
            }
        }
    }
