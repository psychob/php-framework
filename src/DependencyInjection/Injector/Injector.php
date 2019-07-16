<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector;

    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Relation\FunctionDefinition;
    use PsychoB\Framework\DependencyInjection\Relation\RelationDatabaseInterface;
    use PsychoB\Framework\DependencyInjection\Tags\SingletonTag;
    use ReflectionClass;
    use ReflectionFunctionAbstract;

    class Injector implements InjectorInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /** @var RelationDatabaseInterface */
        protected $relations;

        /**
         * Injector constructor.
         *
         * @param ContainerInterface        $container
         * @param RelationDatabaseInterface $relations
         */
        public function __construct(ContainerInterface $container, RelationDatabaseInterface $relations)
        {
            $this->container = $container;
            $this->relations = $relations;
        }

        /** @inheritDoc */
        public function make(string $class, array $arguments = [])
        {
            return $this->inject([$class, '__construct'], $arguments);
        }

        /** @inheritDoc */
        public function inject($callableOrClass, array $arguments = [])
        {
            return $this->injectImpl($callableOrClass, $arguments);
        }

        protected function injectImpl($callableOrClass, array $arguments)
        {
            // PHP allows you to pass callable to class method as array with two elements. First one could be either
            // object or class name. We are doing this here, because is_callable will check if $object has this method
            // and in case of construct it can report it as "don't have" even if it's perfectly legal to construct
            // said object
            if (is_array($callableOrClass)) {
                if (count($callableOrClass) === 2) {
                    if (is_object($callableOrClass[0])) {
                        return $this->injectIntoObject($callableOrClass[0], $callableOrClass[1], $arguments);
                    } else if (is_string($callableOrClass[0])) {
                        return $this->injectIntoClass($callableOrClass[0], $callableOrClass[1], $arguments);
                    }
                }

                throw InvalidInjectException::invalidArrayCallback($callableOrClass);
            }

            if (is_string($callableOrClass)) {
                if (strpos($callableOrClass, '::') !== false) {
                    if (preg_match('/^([^\s:]+)::([^\s:]+)$/', $callableOrClass, $m) === 1) {
                        return $this->injectIntoClass($m[1], $m[2], $arguments);
                    } else {
                        throw InvalidInjectException::invalidStringFormat($callableOrClass);
                    }
                }
            }

            if (is_callable($callableOrClass)) {
                return $this->injectIntoFunction($callableOrClass, $arguments);
            }

            throw InvalidArgumentException::invalidType($callableOrClass);
        }

        /** @inheritDoc */
        public function delegate($callableOrClass, array $arguments = []): callable
        {
            return function () use ($callableOrClass, $arguments) {
                return $this->inject($callableOrClass, $arguments);
            };
        }

        /**
         * This method tries to inject $class->$method using data stored in RelationDatabase.
         *
         * @param string      $class
         * @param string      $method
         * @param array       $arguments
         * @param null|object $object
         *
         * @return array
         */
        protected function injectUsingMemory(string $class, string $method, array $arguments, $object = NULL): array
        {
            $def = $this->relations->getArgumentListFor($class, $method);

            if ($def === NULL) {
                return [false, NULL, NULL];
            }

            if ($def->isOnlyAutowire() || $def->isPartial()) {
                return [false, NULL, $def];
            }

            $args = $this->resolveArguments($def, $arguments);

            if ($method === '__construct') {
                return [true, $this->makeWith($class, $args), $def];
            } else {
                return [true, $this->injectWith($object ?? $class, $method, $args), $def];
            }
        }

        protected function injectIntoObject($object, string $method, array $arguments)
        {
            $className = get_class($object);

            // anonymous classes requires special case
            if (strpos($className, 'class@') === 0) {
                return $this->injectIntoAnonymous($object, $method, $arguments);
            }

            [$success, $ret, $def] = $this->injectUsingMemory($className, $method, $arguments, $object);
            if ($success) {
                return $ret;
            }

            [$list] = $this->fetchArgumentList($className, $method);

            if ($def !== NULL) {
                $def->mergeWith($list);
            } else {
                $def = $list;
            }

            $args = $this->resolveArguments($def, $arguments);

            if ($method === '__construct') {
                return $this->makeWith($className, $args);
            } else {
                return $this->injectWith($object, $method, $args);
            }
        }

        protected function injectIntoClass(string $class, string $method, array $arguments)
        {
            [$success, $ret, $def] = $this->injectUsingMemory($class, $method, $arguments);
            if ($success) {
                return $ret;
            }

            [$list] = $this->fetchArgumentList($class, $method);

            if ($def !== NULL) {
                $def->mergeWith($list);
            } else {
                $def = $list;
            }

            $args = $this->resolveArguments($def, $arguments);

            if ($method === '__construct') {
                return $this->makeWith($class, $args);
            } else {
                return $this->injectWith($class, $method, $args);
            }
        }

        protected function injectIntoAnonymous($object, string $method, array $arguments)
        {
            [$def, $refClass, $refMethod] = $this->fetchArgumentList($object, $method);

            $args = $this->resolveArguments($def, $arguments);

            if ($method === '__construct') {
                return $this->makeWith($refClass, $args);
            } else {
                return $this->injectWith($object, $method, $args);
            }
        }

        protected function injectIntoFunction($callable, array $arguments)
        {
            $def = $this->fetchArgumentListReflection(new \ReflectionFunction($callable), NULL);

            $args = $this->resolveArguments($def, $arguments);

            return $this->injectWith($callable, $args);
        }

        protected function makeWith($klass, array $args)
        {
            /// TODO: Maybe catch and rethrow error that states we have different amount of arguments needed (for
            /// TODO: example list specify 5 arguments but method takes 6). Also catching type different argument
            /// TODO: when user supplied list with different types that method requires.
            if ($klass instanceof ReflectionClass) {
                return $this->makeWithReflection($klass, $args);
            } else {
                return $this->makeWithNew($klass, $args);
            }
        }

        protected function makeWithReflection(ReflectionClass $klass, array $args)
        {
            return $klass->newInstance(...$args);
        }

        protected function makeWithNew($klass, array $args)
        {
            return new $klass(...$args);
        }

        protected function injectWith($object, $method, $args = NULL)
        {
            /// TODO: Maybe catch and rethrow error that states we have different amount of arguments needed (for
            /// TODO: example list specify 5 arguments but method takes 6). Also catching type different argument
            /// TODO: when user supplied list with different types that method requires.
            if ($args === NULL) {
                return $this->injectWithFunction($object, $method);
            } else {
                return $this->injectWithClass($object, $method, $args);
            }
        }

        protected function injectWithClass($object, string $method, array $args)
        {
            return call_user_func_array([$object, $method], $args);
        }

        protected function injectWithFunction($function, array $args)
        {
            return call_user_func_array($function, $args);
        }

        protected function fetchArgumentList($class, string $method, ?string $className = NULL): array
        {
            $refClass = new ReflectionClass($class);

            if ($method === '__construct') {
                $refMethod = $refClass->getConstructor();
            } else {
                $refMethod = $refClass->getMethod($method);
            }

            // at this point we know that $refMethod === null when we have no constructor defined in class
            // so we can just create new instance of $object
            if ($refMethod === NULL) {
                return [(new FunctionDefinition\Builder($className ?? $refClass->getName(), $method))->build(),
                        $refClass,
                        $refMethod];
            }

            return [$this->fetchArgumentListReflection($refMethod, $className ?? $refClass->getName()), $refClass,
                    $refMethod];
        }

        protected function fetchArgumentListReflection(ReflectionFunctionAbstract $refMethod,
                                                       ?string $className): FunctionDefinition\Info
        {
            $argBuilder = new FunctionDefinition\Builder($className, $refMethod->getName());

            foreach ($refMethod->getParameters() as $no => $param) {
                if (!$param->hasType()) {
                    $argBuilder->addTypelessArgument($no, $param->getName(), $param->isDefaultValueAvailable(),
                                                     $param->isDefaultValueAvailable() ? $param->getDefaultValue() : NULL);
                } else {
                    $type = $param->getType();
                    $argBuilder->addArgument($no, $param->getName(), $type->getName(), $type->isBuiltin(),
                                             $type->allowsNull(), $param->isDefaultValueAvailable(),
                                             $param->isDefaultValueAvailable() ? $param->getDefaultValue() : NULL);
                }
            }

            return $argBuilder->build();
        }

        protected function resolveArguments(FunctionDefinition\Info $def, array $arguments): array
        {
            $ret = [];

            /** @var FunctionDefinition\Argument $arg */
            foreach ($def->iterate() as $arg) {
                // did user supplied $argument in any way
                if (array_key_exists($arg->getName(), $arguments)) { // named arg
                    if ($arguments[$arg->getName()] instanceof ResolveClass) {
                        $ret[] = $this->resolve($arguments[$arg->getName()]->getClassName());
                    } else {
                        $ret[] = $arguments[$arg->getName()];
                    }
                    continue;
                }

                if (array_key_exists($arg->getNo(), $arguments)) {
                    if ($arguments[$arg->getNo()] instanceof ResolveClass) {
                        $ret[] = $this->resolve($arguments[$arg->getNo()]->getClassName());
                    } else {
                        $ret[] = $arguments[$arg->getNo()];
                    }
                    continue;
                }

                // then if user wired it in any special way
                if ($arg->getWire()) {
                    if (!$arg->getWire()->isLiteral()) {
                        $ret[] = $this->resolve($arg->getWire()->getType());
                    } else {
                        $ret[] = $arg->getWire()->getLiteral();
                    }

                    continue;
                }

                if ($arg->getType()) {
                    /// TODO: isBuiltin / allowNull
                    $ret[] = $this->resolve($arg->getType()->getName());
                    continue;
                }

                if ($arg->getDefault()->isHas()) {
                    $ret[] = $arg->getDefault()->getValue();
                    continue;
                }

                throw new CantInjectParameterException($arg);
            }

            return $ret;
        }

        protected function resolve(string $class)
        {
            if ($this->container->has($class)) {
                return $this->container->get($class);
            }

            $ret = $this->make($class);

            if ($ret instanceof SingletonTag) {
                $this->container->add(get_class($ret), $ret);
            }

            return $ret;
        }
    }
