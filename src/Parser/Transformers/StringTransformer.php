<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Transformers;

    use PsychoB\Framework\Parser\Tokens\StringToken;
    use PsychoB\Framework\Parser\Tokens\TokenInterface;

    class StringTransformer implements TransformerInterface
    {
        protected $stringEscape = '\\';
        protected $stringStart = '"';
        protected $stringEnd = '"';

        /**
         * StringTransformer constructor.
         *
         * @param string $escape
         * @param string $stringStart
         * @param string $endString
         */
        public function __construct(string $escape = '\\', string $stringStart = '"', string $endString = '"')
        {
            $this->stringEscape = $escape;
            $this->stringStart = $stringStart;
            $this->stringEnd = $endString;
        }

        public function transform($input)
        {
            $strContent = [];
            $strStarted = false;
            $nextRaw = false;

            /** @var TokenInterface $token */
            foreach ($input as $token) {
                if ($strStarted && $nextRaw) {
                    $strContent[] = $token;
                    $nextRaw = false;
                } else if (!$strStarted && $token->getToken() === $this->stringStart) {
                    $strStarted = true;
                } else if ($strStarted && $token->getToken() === $this->stringEnd) {
                    $strStarted = false;
                    yield StringToken::fromRange($strContent);
                    $strContent = [];
                } else if ($strStarted && $token->getToken() === $this->stringEscape) {
                    $nextRaw = true;
                } else if ($strStarted) {
                    $strContent[] = $token;
                } else {
                    yield $token;
                }
            }

            if (!empty($strContent)) {
                throw new InvalidStringException($strContent);
            }
        }
    }
