<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\TypeProperties;

    use PsychoB\Framework\Assert\Exception\AssertionException;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class TypeDoesntMatchException extends AssertionException
    {
        /** @var string[]|string */
        protected $types;

        public function __construct($obj, $types, ?string $customMessage = NULL, Throwable $previous = NULL)
        {
            $this->types = $types;

            parent::__construct($obj,
                'type-match',
                sprintf('Type: %s did not match specification: %s', Str::toType($obj), $this->getReadableTypes()),
                $customMessage,
                $previous);
        }

        /**
         * @return mixed
         */
        public function getTypes()
        {
            return $this->types;
        }

        private function getReadableTypes(): string
        {
            $readable = [];

            if (Str::is($this->types)) {
                $types = [$this->types];
            } else {
                $types = $this->types;
            }

            foreach ($types as $type) {
                if (Str::is($type)) {
                    if (Str::startsWith($type, '*')) {
                        $readable[] = 'scalar ' . Str::substr($type, 1);
                    } else {
                        $readable[] = 'is class ' . $type;
                    }
                } else {
                    $readable[] = $type['type'] . ' ' . $type['class'];
                }
            }

            return Arr::implode($readable, ' or ');
        }
    }
