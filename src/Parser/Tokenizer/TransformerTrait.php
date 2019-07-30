<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer;

    use PsychoB\Framework\Parser\Transformers\TransformerInterface;
    use PsychoB\Framework\Utility\Str;

    trait TransformerTrait
    {
        /** @var string[] */
        protected $transformers = [];

        public function addPass($class): void
        {
//            AssertArgument::hasType($class, [
//                AssertArgumentType::TYPE_STRING,
//                AssertArgumentType::implementsInterface(TransformerInterface::class),
//            ], 1, 'class');

            $this->transformers[] = $class;
        }

        protected function addTransformations($input)
        {
            foreach ($this->transformers as $transformer) {
                if (Str::is($transformer)) {
                    $transformer = $this->resolver->resolve($transformer);
                }

                /** @var TransformerInterface $transformer */
                $input = $transformer->transform($input);
            }

            return $input;
        }
    }
