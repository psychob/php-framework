<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Assert\Constraints\TypeProperties;

    use PsychoB\Framework\Assert\Constraints\AssertionFailureException;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;
    use Throwable;

    class TypeSpecificationNotSatisfiedException extends AssertionFailureException
    {
        private $value;
        private $types;

        public function __construct($value,
            $types,
            ?string $customMessage = NULL,
            ?Throwable $previous = NULL)
        {
            $this->value = $value;
            $this->types = $types;

            parent::__construct('type-is',
                sprintf('Value %s does not match one of expected types: %s', Str::toRepr($value),
                    $this->getTypeDefinition()), $customMessage, -1, $previous);
        }

        private function getTypeDefinition(): string
        {
            if (Str::is($this->types)) {
                return Str::substr($this->types, 1);
            } else {
                return Arr::implode($this->types, ' , ');
            }
        }
    }
