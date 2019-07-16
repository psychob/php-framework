<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition;

    class Builder
    {
        /** @var null|string */
        protected $className;

        /** @var null|string */
        protected $methodName;

        /** @var array */
        protected $arguments = [];

        /**
         * Builder constructor.
         *
         * @param string|null $className
         * @param string|null $methodName
         */
        public function __construct(?string $className, ?string $methodName)
        {
            $this->className = $className;
            $this->methodName = $methodName;
        }

        public function addArgument(int $position,
                                    string $name,
                                    string $typeName,
                                    bool $isBuiltin,
                                    bool $allowsNull,
                                    bool $isDefaultValueAvailable,
                                    $defaultValue = NULL): void
        {
            $this->arguments[] = [
                'no'      => $position,
                'name'    => $name,
                'type'    => [
                    'name'    => $typeName,
                    'builtin' => $isBuiltin,
                    'null'    => $allowsNull,
                ],
                'default' => [
                    'has'   => $isDefaultValueAvailable,
                    'value' => $defaultValue,
                ],
            ];
        }

        public function addTypelessArgument(int $position,
                                            string $name,
                                            bool $isDefaultValueAvailable,
                                            $defaultValue = NULL): void
        {
            $this->arguments[] = [
                'no'      => $position,
                'name'    => $name,
                'default' => [
                    'has'   => $isDefaultValueAvailable,
                    'value' => $defaultValue,
                ],
            ];
        }

        public function build(): Info
        {
            $named = [];
            $pos = [];

            foreach ($this->arguments as $no => $param) {
                $pos[$param['no']] = $no;
                $named[$param['name']] = $no;
            }

            $args = [];
            foreach ($this->arguments as $a) {
                $type = NULL;

                if ($a['type']) {
                    $type = new Type($a['type']['name'], $a['type']['builtin'], $a['type']['null']);
                }

                $args[] = new Argument($a['no'], $a['name'], $type,
                                       new Default_($a['default']['has'], $a['default']['value']), NULL);
            }

            return new Info($this->className, $this->methodName, $args, $named, $pos);
        }
    }
