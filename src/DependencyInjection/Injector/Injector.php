<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\DependencyInjection\Injector;

    use PsychoB\Framework\DependencyInjection\Container\ContainerInterface;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\AmbiguousInjectionException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\CircularDependencyDetectedException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\InjectArgumentNotFoundException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\InvalidCallableException;
    use PsychoB\Framework\DependencyInjection\Injector\Exception\StaticCallNormalMethodException;
    use PsychoB\Framework\DependencyInjection\Injector\Lookup\ArgumentLookupInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\Utility\Arr;
    use PsychoB\Framework\Utility\Str;
    use ReflectionClass;
    use ReflectionFunction;
    use ReflectionFunctionAbstract;
    use ReflectionMethod;

    class Injector implements InjectorInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /** @var ResolverInterface */
        protected $resolver;

        /** @var string[] */
        protected $currentlyMaking = [];

        /**
         * Injector constructor.
         *
         * @param ContainerInterface $container
         * @param ResolverInterface  $resolver
         */
        public function __construct(ContainerInterface $container, ResolverInterface $resolver)
        {
            $this->container = $container;
            $this->resolver = $resolver;
        }

        /** @inheritDoc */
        public function inject($callable, array $arguments = [])
        {
            if (is_array($callable)) {
                if (count($callable) === 2) {
                    if (is_string($callable[1])) {
                        if (is_object($callable[0])) {
                            return $this->injectIntoObject($callable[0], $callable[1], $arguments);
                        } else if (is_string($callable[0])) {
                            return $this->injectIntoClass($callable[0], $callable[1], $arguments);
                        }

                        throw InvalidCallableException::invalidArrayFormat($callable);
                    }
                }

                throw InvalidCallableException::invalidArrayFormat($callable);
            }

            if (is_string($callable)) {
                $matches = Str::matchGroups('/^([^:]+)::([^:]+)$/', $callable);
                if ($matches !== false) {
                    return $this->injectIntoClass($matches[0], $matches[1], $arguments);
                }

                return $this->injectIntoFunction($callable, $arguments);
            }

            if (is_callable($callable)) {
                return $this->injectIntoFunction($callable, $arguments);
            }

            throw InvalidCallableException::invalidCallable($callable);
        }

        /** @inheritDoc */
        public function make(string $class, array $arguments = [])
        {
            return $this->inject([$class, '__construct'], $arguments);
        }

        protected function injectIntoClass(string $class, string $method, array $arguments = [])
        {
            $refClass = new ReflectionClass($class);

            if ($method === '__construct') {
                return $this->makeFrom($refClass, $arguments);
            } else {
                return $this->injectInto($refClass, $method, $arguments);
            }
        }

        protected function injectIntoObject($object, string $method, array $arguments = [])
        {
            $refClass = new ReflectionClass($object);

            if ($method === '__construct') {
                return $this->makeFrom($refClass, $arguments);
            } else {
                return $this->injectInto($refClass, $method, $arguments, $object);
            }
        }

        protected function injectIntoFunction($object, array $arguments = [])
        {
            $refMethod = new ReflectionFunction($object);

            $args = $this->fetchArgsFrom($refMethod, $arguments);

            return $this->injectWith($refMethod, $args);
        }

        protected function makeFrom(ReflectionClass $refClass, array $arguments)
        {
            if (Arr::contains($this->currentlyMaking, $refClass->getName())) {
                throw new CircularDependencyDetectedException($refClass->getName(), $this->currentlyMaking);
            }

            try {
                Arr::push($this->currentlyMaking, $refClass->getName());

                $constructor = $refClass->getConstructor();

                if ($constructor === NULL) {
                    return $this->makeWith($refClass);
                } else {
                    $customInjection = [];
                    if ($refClass->implementsInterface(CustomInjectionInterface::class)) {
                        $customInjection = $this->inject([$refClass->getName(),
                                                          CustomInjectionInterface::PBFW_CUSTOM_INJECTION_METHOD]);

                        if (Arr::has($customInjection, '__construct')) {
                            $customInjection = $customInjection['__construct'];
                        } else {
                            $customInjection = [];
                        }
                    }

                    $args = $this->fetchArgsFrom($constructor, $arguments, $refClass->getName(), $customInjection);

                    return $this->makeWith($refClass, $args);
                }
            } finally {
                Arr::pop($this->currentlyMaking);
            }
        }

        protected function injectInto(ReflectionClass $refClass, string $method, array $arguments, $object = NULL)
        {
            $refMethod = $refClass->getMethod($method);

            if ($object === NULL && !$refMethod->isStatic()) {
                throw new StaticCallNormalMethodException($refClass->getName(), $method);
            }

            $customInjection = [];
            if ($method !== CustomInjectionInterface::PBFW_CUSTOM_INJECTION_METHOD) {
                if ($refClass->implementsInterface(CustomInjectionInterface::class)) {
                    $customInjection = $this->inject([$refClass->getName(),
                                                      CustomInjectionInterface::PBFW_CUSTOM_INJECTION_METHOD]);

                    if (Arr::has($customInjection, $method)) {
                        $customInjection = $customInjection[$method];
                    } else {
                        $customInjection = [];
                    }
                }
            }

            $args = $this->fetchArgsFrom($refMethod, $arguments, $refClass->getName(), $customInjection);

            return $this->injectWith($refMethod, $args, $object);
        }

        /**
         * Make new instance from $ref and arguments
         *
         * @param ReflectionClass $ref
         * @param mixed[]         $arguments
         *
         * @return object
         */
        protected function makeWith(ReflectionClass $ref, array $arguments = [])
        {
            return $ref->newInstance(...$arguments);
        }

        protected function injectWith(ReflectionFunctionAbstract $method, array $arguments, $object = NULL)
        {
            if ($method instanceof ReflectionMethod) {
                if ($object) {
                    return $method->invoke($object, ...$arguments);
                } else {
                    return call_user_func_array([$method->getDeclaringClass()->getName(), $method->getName()],
                                                $arguments);
                }
            } else if ($method instanceof ReflectionFunction) {
                return $method->invoke(...$arguments);
            }
        }

        protected function fetchArgsFrom(ReflectionFunctionAbstract $callable,
                                         array $arguments,
                                         ?string $class = NULL,
                                         array $injectArguments = []): array
        {
            $ret = [];

            foreach ($callable->getParameters() as $no => $parameter) {
                $pName = $parameter->getName();

                if (Arr::hasMultiple($arguments, $pName, $no)) {
                    throw new AmbiguousInjectionException($no, $pName, [$class, $callable->getName()], [
                        $arguments[$pName], $arguments[$no],
                    ]);
                }

                if (Arr::has($arguments, $no)) {
                    if ($arguments[$no] instanceof ArgumentLookupInterface) {
                        $ret[] = $arguments[$no]->resolve($this->resolver);
                    } else {
                        $ret[] = $arguments[$no];
                    }

                    continue;
                }

                if (Arr::has($arguments, $pName)) {
                    if ($arguments[$pName] instanceof ArgumentLookupInterface) {
                        $ret[] = $arguments[$pName]->resolve($this->resolver);
                    } else {
                        $ret[] = $arguments[$pName];
                    }

                    continue;
                }

                if (Arr::has($injectArguments, $pName)) {
                    if ($injectArguments[$pName] instanceof ArgumentLookupInterface) {
                        $ret[] = $injectArguments[$pName]->resolve($this->resolver);
                    } else {
                        $ret[] = $injectArguments[$pName];
                    }

                    continue;
                }

                $type = $parameter->getType();
                if ($type !== NULL) {
                    if (!$type->isBuiltin()) {
                        $ret[] = $this->resolver->resolve($type->getName(), [], $class);
                        continue;
                    }
                }

                if ($parameter->isDefaultValueAvailable()) {
                    $ret[] = $parameter->getDefaultValue();
                    continue;
                }

                if ($type !== NULL) {
                    if ($type->allowsNull()) {
                        $ret[] = NULL;
                    }
                }

                throw new InjectArgumentNotFoundException($no, $pName, [$class, $callable->getName()]);
            }

            return $ret;
        }
    }
