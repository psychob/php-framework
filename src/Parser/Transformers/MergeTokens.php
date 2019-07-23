<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Transformers;

    use PsychoB\Framework\Parser\Tokens\DebugInfo;
    use PsychoB\Framework\Parser\Tokens\LiteralToken;

    class MergeTokens implements TransformerInterface
    {
        public function transform($iterable)
        {
            $merged = [];

            foreach ($iterable as $token) {
                if ($token instanceof LiteralToken) {
                    $merged[] = $token;
                } else {
                    if (!empty($merged)) {
                        if (count($merged) === 1) {
                            yield $merged[0];
                        } else {
                            $tok = '';

                            $start = PHP_INT_MAX;
                            $end = PHP_INT_MIN;
                            $line = PHP_INT_MAX;

                            /** @var LiteralToken $token */
                            foreach ($merged as $token) {
                                $tok .= $token->getToken();

                                $start = min($start, $token->getDebug()->getStart());
                                $end = min($end, $token->getDebug()->getEnd());
                                $line = min($line, $token->getDebug()->getLine());
                            }

                            yield new LiteralToken($tok, new DebugInfo($start, $end, $line));
                        }

                        $merged = [];
                    }

                    yield $token;
                }
            }

            if (!empty($merged)) {
                if (count($merged) === 1) {
                    yield $merged[0];
                } else {
                    $tok = '';

                    $start = PHP_INT_MAX;
                    $end = PHP_INT_MIN;
                    $line = PHP_INT_MAX;

                    /** @var LiteralToken $token */
                    foreach ($merged as $token) {
                        $tok .= $token->getToken();

                        $start = min($start, $token->getDebug()->getStart());
                        $end = min($end, $token->getDebug()->getEnd());
                        $line = min($line, $token->getDebug()->getLine());
                    }

                    yield new LiteralToken($tok, new DebugInfo($start, $end, $line));
                }

                $merged = [];
            }
        }
    }
