<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Exception;

    use Throwable;

    class BaseElementNotFoundException extends BaseException
    {
        /** @var array|null */
        protected $array;

        /** @var mixed */
        protected $key;

        /** @var boolean */
        protected $onlyKeys;

        /**
         * BaseElementNotFoundException constructor.
         *
         * @param array|null     $array
         * @param mixed          $key
         * @param bool           $onlyKeys
         * @param string         $message
         * @param Throwable|null $previous
         */
        public function __construct(?array $array,
                                    $key,
                                    bool $onlyKeys = false,
                                    string $message = '',
                                    ?Throwable $previous = NULL)
        {
            $this->array = $array;
            $this->key = $key;
            $this->onlyKeys = $onlyKeys;

            parent::__construct($this->generateMessage($message), 0, $previous);
        }

        protected function generateMessage(string $message): string
        {
            $ret = $message;

            /// TODO: Use $this->array to calculate if user made a mistake with spelling
            $ret .= sprintf(': Element %s not found', strval($this->key));

            return $ret;
        }

        /**
         * @return array|null
         */
        public function getArray(): ?array
        {
            return $this->array;
        }

        /**
         * @return mixed
         */
        public function getKey()
        {
            return $this->key;
        }

        /**
         * @return bool
         */
        public function isOnlyKeys(): bool
        {
            return $this->onlyKeys;
        }
    }
