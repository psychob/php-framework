<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser;

    use PsychoB\Framework\Injector\Tag\InstanceTag;
    use PsychoB\Framework\Parser\Tokens\DebugInfo;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;
    use PsychoB\Framework\Parser\Tokens\NewLineToken;
    use PsychoB\Framework\Parser\Tokens\SymbolToken;
    use PsychoB\Framework\Parser\Tokens\Token;
    use PsychoB\Framework\Parser\Tokens\WhiteSpaceToken;
    use PsychoB\Framework\Parser\Transformers\MakeStringTokens;
    use PsychoB\Framework\Parser\Transformers\MergeLines;
    use PsychoB\Framework\Parser\Transformers\MergeTokens;
    use PsychoB\Framework\Parser\Transformers\TransformerInterface;

    class Tokenizer implements InstanceTag
    {
        /** @var string[] */
        protected $keywords = [];

        /** @var string[] */
        protected $symbols = [];

        /** @var TransformerInterface */
        protected $transformers = [];

        public function __construct()
        {
            $this->transformers = [
                new MergeTokens(),
                new MakeStringTokens(),
                new MergeLines(),
            ];
        }

        /**
         * @return string[]
         */
        public function getKeywords(): array
        {
            return $this->keywords;
        }

        /**
         * @param string[] $keywords
         */
        public function setKeywords(array $keywords): void
        {
            $this->keywords = $keywords;
        }

        /**
         * @return string[]
         */
        public function getSymbols(): array
        {
            return $this->symbols;
        }

        /**
         * @param string[] $symbols
         */
        public function setSymbols(array $symbols): void
        {
            $this->symbols = $symbols;
        }

        public function tokenizeFile(string $path): array
        {
            return $this->tokenize(file_get_contents($path));
        }

        public function tokenize(string $content): array
        {
            $tokens = $this->scanForTokens($content);

            foreach ($this->transformers as $transformer) {
                $tokens = $transformer->transform($tokens);
            }

            return iterator_to_array($tokens);
        }

        protected function scanForTokens(string $content)
        {
            foreach (explode("\n", $content) as $no => $line) {
                if (empty(trim($line))) {
                    continue;
                }

                foreach ($this->scanLine($line, $no) as $token) {
                    yield $token;
                }
            }
        }

        protected function makeDebugInfo(int $start, int $end, int $line): DebugInfo
        {
            return new DebugInfo($start, $end, $line);
        }

        protected function newToken(string $token, int $start, int $end, string $type, int $line): Token
        {
            switch ($type) {
                case 'literal':
                    return new LiteralToken($token, $this->makeDebugInfo($start, $end, $line));

                case 'whitespace':
                    return new WhiteSpaceToken($token, $this->makeDebugInfo($start, $end, $line));

                case 'symbol':
                    return new SymbolToken($token, $this->makeDebugInfo($start, $end, $line));
            }
        }

        protected function scanLine(string $line, $no): iterable
        {
            for ($it = 0; $it < strlen($line);) {
                foreach ($this->fetchWhitespaceTokens($line, $it, $no) as [$token, $nit]) {
                    yield $token;
                    $it = $nit;
                }

                foreach ($this->fetchSymbolTokens($line, $it, $no) as [$token, $nit]) {
                    yield $token;
                    $it = $nit;
                }

                foreach ($this->fetchLiteralTokens($line, $it, $no) as [$token, $nit]) {
                    yield $token;
                    $it = $nit;
                }
            }

            yield new NewLineToken($this->makeDebugInfo($it, $it, $no + 1));
        }

        protected function fetchWhitespaceTokens(string $line, int $idx, int $no): iterable
        {
            $tmp = '';

            for ($it = $idx; $it < strlen($line); ++$it) {
                if (!$this->isWhiteSpace($line[$it])) {
                    if ($tmp !== '') {
                        yield [$this->newToken($tmp, $idx, $it, 'whitespace', $no), $it];
                    }

                    return;
                }

                $tmp .= $line[$it];
            }

            if (!empty($tmp)) {
                yield [$this->newToken($tmp, $idx, $it, 'whitespace', $no), strlen($line)];
            }
        }

        protected function fetchSymbolTokens(string $line, int $idx, int $no): iterable
        {
            if ($this->canBeSymbol($line[$idx])) {
                for ($it = $idx + 1; $it < strlen($line); ++$it) {
                    if ($this->canBeSymbol(substr($line, $idx, $it - $idx))) {
                        continue;
                    } else if ($this->isSymbol(substr($line, $idx, $it - $idx - 1))) {
                        yield [$this->newToken(substr($line[$idx], $idx, $it - $idx - 1),
                                               $idx, $idx + 1, 'symbol', $no), $idx + 1];
                        return;
                    } else {
                        break;
                    }
                }
            }

            if ($this->isSymbol($line[$idx])) {
                yield [$this->newToken($line[$idx], $idx, $idx + 1, 'symbol', $no), $idx + 1];
            }

            return;
        }

        protected function fetchLiteralTokens(string $line, int $idx, int $no): iterable
        {
            $tmp = '';

            for ($it = $idx; $it < strlen($line); ++$it) {
                if ($this->isWhiteSpace($line[$it]) ||
                    $this->isSymbol($line[$it]) ||
                    ($idx !== $it && $this->canBeSymbol($line[$it]))) {
                    if ($tmp !== '') {
                        yield [$this->newToken($tmp, $idx, $it, 'literal', $no), $it];
                    }

                    return;
                }

                $tmp .= $line[$it];
            }

            if ($tmp !== '') {
                yield [$this->newToken($tmp, $idx, $it, 'literal', $no), strlen($line)];
            }
        }

        private function isWhiteSpace(string $it): bool
        {
            return $it === ' ' || $it === "\n" || $it === "\t";
        }

        protected function isSymbol(string $it, string $txt = ''): bool
        {
            return in_array($txt . $it, $this->symbols);
        }

        protected function canBeSymbol(string $it, string $txt = ''): bool
        {
            foreach ($this->symbols as $s) {
                if (strlen($s) > 1) {
                    $str = $txt . $it;
                    $substr = substr($s, 0, strlen($str));

                    if ($str === $substr) {
                        return true;
                    }
                }
            }

            return false;
        }
    }
