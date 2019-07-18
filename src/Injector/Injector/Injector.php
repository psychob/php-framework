<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Injector\Injector;

    use PsychoB\Framework\Injector\Container\ContainerInterface;
    use PsychoB\Framework\Injector\Exceptions\CanNotResolveArgumentException;
    use PsychoB\Framework\Injector\Exceptions\InvalidCallableException;
    use PsychoB\Framework\Injector\Exceptions\StaticCallOfNonStaticFunctionException;
    use ReflectionClass;
    use ReflectionFunctionAbstract;

    class Injector implements InjectorInterface
    {
        /** @var ContainerInterface */
        protected $container;

        /**
         * Injector constructor.
         *
         * @param ContainerInterface $container
         */
        public function __construct(ContainerInterface $container)
        {
            $this->container = $container;

            $this->container->add(InjectorInterface::class, $this, ContainerInterface::ADD_IGNORE);
            $this->container->add(Injector::class, $this);
        }

        /** @inheritDoc */
        public function inject($object, array $arguments = [])
        {
            return $this->injectImpl($object, $arguments);
        }

        protected function injectImpl($callable, array $arguments)
        {
            // we could just use is_callable, to test if we can inject anything into it but it report that class that
            // don't have defined __construct are not callable (for example if class and it parents never bother to
            // define __construct).
            if (is_array($callable)) {
                if (count($callable) === 2) {
                    if (is_string($callable[0])) {
                        return $this->injectInClass($callable[0], $callable[1], $arguments);
                    }

                    if (is_object($callable[0])) {
                        return $this->injectInObject($callable[0], $callable[1], $arguments);
                    }
                }

                throw InvalidCallableException::invalidArrayFormat($callable, $arguments);
            }

            if (is_string($callable)) {
                if (strpos($callable, '::') !== false) {
                    if (preg_match('/^([^\s:]+)::([^\s:]+)$/', $callable, $m) === 1) {
                        return $this->injectInClass($m[1], $m[2], $arguments);
                    } else {
                        throw InvalidCallableException::invalidStringFormat($callable, $arguments);
                    }
                }
            }

            if (is_callable($callable)) {
                return $this->injectInFunction($callable);
            }

            throw InvalidCallableException::unknownFormat($callable, $arguments);
        }

        protected function injectInClass(string $class, string $method, array $arguments)
        {
            try {
                $refClass = new ReflectionClass($class);
            } catch (\ReflectionException $e) {
                throw new ClassNotFoundException($class);
            }

            if ($method === '__construct') {
                return $this->makeFromReflection($refClass, $arguments);
            } else {
                return $this->injectFromReflection($refClass, $method, $arguments);
            }
        }

        protected function injectInObject($object, string $method, array $arguments)
        {
            try {
                $refClass = new ReflectionClass($object);
            } catch (\ReflectionException $e) {
                throw new ClassNotFoundException(get_class($object));
            }

            if ($method === '__construct') {
                return $this->makeFromReflection($refClass, $arguments);
            } else {
                return $this->injectFromReflection($refClass, $method, $arguments, $object);
            }
        }

        protected function injectFromReflection(ReflectionClass $ref, string $method, array $arguments, $object = NULL)
        {
            try {
                $refMethod = $ref->getMethod($method);
            } catch (\ReflectionException $e) {
                throw new MethodNotFoundInClassException($ref->getName(), $method);
            }

            if (!$refMethod->isStatic() && $object === NULL) {
                throw new StaticCallOfNonStaticFunctionException($ref->getName(), $method);
            }

            $args = $this->resolveArguments($refMethod, $arguments, $ref->getName());

            if ($refMethod->isStatic()) {
                return call_user_func_array([$ref->getName(), $method], $args);
            } else {
                return call_user_func_array([$object, $method], $args);
            }
        }

        protected function makeFromReflection(ReflectionClass $refClass, array $arguments)
        {
            $constructor = $refClass->getConstructor();

            if ($constructor === NULL) {
                return $this->make($refClass);
            }

            $args = $this->resolveArguments($constructor, $arguments, $refClass->getName());

            return $this->make($refClass, $args);
        }

        protected function make(ReflectionClass $refClass, array $arguments = [])
        {
            return $refClass->newInstance(...$arguments);
        }

        protected function resolveArguments(ReflectionFunctionAbstract $method, array $arguments, ?string $className = null): array
        {
            $ret = [];

            foreach ($method->getParameters() as $no => $param) {
                if (array_key_exists($no, $arguments)) {
                    $ret[] = $arguments[$no];
                    continue;
                }

                if (array_key_exists($param->getName(), $arguments)) {
                    $ret[] = $arguments[$param->getName()];
                    continue;
                }

                $type = $param->getType();

                if ($type !== NULL && !$type->isBuiltin()) {
                    $ret[] = $this->container->resolve($type->getName());
                    continue;
                }

                if ($param->isDefaultValueAvailable()) {
                    $ret[] = $param->getDefaultValue();
                    continue;
                }

                throw new CanNotResolveArgumentException($className ?? '', $method->getName(), $param->getName(), $no);
            }

            return $ret;
        }
    }
