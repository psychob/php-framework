<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser;

    use PsychoB\Framework\DependencyInjection\Resolver\ResolverInterface;
    use PsychoB\Framework\DependencyInjection\Resolver\Tag\ResolverNeverCache;
    use PsychoB\Framework\Parser\Tokenizer\TokenizerTrait;
    use PsychoB\Framework\Parser\Tokenizer\TransformerTrait;

    class Tokenizer implements ResolverNeverCache
    {
        use TransformerTrait,
            TokenizerTrait;

        /** @var ResolverInterface */
        protected $resolver;

        /**
         * Tokenizer constructor.
         *
         * @param ResolverInterface $resolver
         */
        public function __construct(ResolverInterface $resolver)
        {
            $this->resolver = $resolver;
        }

        public function tokenizeFile(string $path)
        {
            return $this->tokenize(file_get_contents($path));
        }

        public function tokenize(string $content)
        {
            $tokens = $this->tokenizeImpl($content);

            return $this->addTransformations($tokens);
        }
    }
