<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer;

    use PsychoB\Framework\Assert\Assert;
    use PsychoB\Framework\DependencyInjection\Resolver\Tag\ResolverNeverCache;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\TokenInterface;
    use PsychoB\Framework\Utility\Arr;

    class Tokenizer implements ResolverNeverCache
    {
        /** @var mixed[] */
        protected $groups = [
            'literal' => [
                'name' => 'literal',
                'symbols' => [],
                'class' => LiteralToken::class,
                'allow_combining' => true,
            ],
        ];

        public function addGroup(string $name, array $symbols, string $class, bool $allowCombining): void
        {
            Assert::arguments('Group already exists', $name, 1)
                  ->hasNoKey($this->groups, $name);

            Assert::arguments('Class must implement interface TokenInterface', $class, 3)
                  ->classImplements($class, TokenInterface::class);

            $this->groups[$name] = [
                'name' => $name,
                'symbols' => $symbols,
                'class' => $class,
                'allow_combining' => $allowCombining,
            ];
        }

        public function hasGroup(string $name): bool
        {
            return Arr::has($this->groups, $name);
        }

        public function removeGroup(string $name): void
        {
            unset($this->groups[$name]);
        }

        public function addDefaultGroups(): void
        {
        }

        public function tokenizeFile(string $path): TokenFileStream
        {
            return new TokenFileStream($path, $this->groups);
        }

        public function tokenize(string $content): TokenStream
        {
            return new TokenStream($content, $this->groups);
        }
    }
