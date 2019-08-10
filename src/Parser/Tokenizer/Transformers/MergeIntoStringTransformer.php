<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Tokenizer\Transformers;

    use PsychoB\Framework\Parser\Tokenizer\Tokens\StringToken;
    use PsychoB\Framework\Parser\Tokenizer\Tokens\TokenInterface;
    use PsychoB\Framework\Utility\Arr;

    class MergeIntoStringTransformer implements TransformerInterface
    {
        protected $startString = '"';
        protected $endString = '"';
        protected $escapeString = '\\';

        /**
         * MergeIntoStringTransformer constructor.
         *
         * @param string $startString
         * @param string $endString
         * @param string $escapeString
         */
        public function __construct(string $startString = '"', string $endString = '"', string $escapeString = '\\')
        {
            $this->startString = $startString;
            $this->endString = $endString;
            $this->escapeString = $escapeString;
        }

        /** @inheritDoc */
        public function transform($input)
        {
            $tmp = [];
            $started = false;
            $appendNext = false;

            /** @var TokenInterface $token */
            foreach ($input as $token) {
                if ($appendNext) {
                    $tmp[] = $token;
                    $appendNext = false;
                } else if ($started) {
                    if ($token->getToken() === $this->escapeString) {
                        $appendNext = true;
                    } else if ($token->getToken() === $this->endString) {
                        $tmp[] = $token;
                        yield $this->mergeTokens($tmp);

                        $started = false;
                        $tmp = [];
                    } else {
                        $tmp[] = $token;
                    }
                } else if ($token->getToken() === $this->startString) {
                    $tmp[] = $token;
                    $started = true;
                } else {
                    yield $token;
                }
            }
        }

        /**
         * @param TokenInterface[] $tmp
         *
         * @return TokenInterface
         */
        private function mergeTokens(array $tmp): TokenInterface
        {
            $innerTokens = Arr::slice($tmp, 1, Arr::len($tmp) - 2);
            $first = Arr::first($tmp);
            $last = Arr::last($tmp);

            $tokens = '';
            foreach ($innerTokens as $token) {
                $tokens .= $token->getToken();
            }

            return new StringToken($tokens, $first->getStart(), $last->getEnd());
        }
    }
