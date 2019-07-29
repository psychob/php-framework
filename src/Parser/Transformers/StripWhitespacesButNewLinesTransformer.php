<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace PsychoB\Framework\Parser\Transformers;

    use Generator;
    use PsychoB\Framework\Parser\Tokens\NewLineToken;
    use PsychoB\Framework\Parser\Tokens\WhitespaceToken;
    use PsychoB\Framework\Utility\Str;

    class StripWhitespacesButNewLinesTransformer implements TransformerInterface
    {
        public function transform($input): Generator
        {
            foreach ($input as $token) {
                if ($token instanceof WhitespaceToken) {
                    $tok = $token->getToken();
                    $offset = 0;

                    $hasNewLine = Str::findFirst($tok, "\n");

                    while (($it = Str::findFirst($tok, "\n")) !== false) {
                        yield new NewLineToken("\n", $token->getStart() + $offset, $token->getStart() + $offset + 1);

                        $tok = Str::substr($tok, $offset + $it + 1);
                        $offset += $it;
                    }
                } else {
                    yield $token;
                }
            }
        }
    }
