<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Parser\Matcher;

    use PsychoB\Framework\Parser\Matcher\Matcher;
    use PsychoB\Framework\Testing\UnitTestCase;

    class MatcherTest extends UnitTestCase
    {
        public function testMatcher()
        {
            $matcher = new Matcher();

            $matcher->addMatch(Matcher::MATCH_START, '(tree-start | route)*')
                    ->addMatch('tree-start', '$INTEND=intend-space? tree-prefix whitespace ":" new-line (($INTEND$)< (tree-start | route))*', Matcher::FLAG_NODE)
                    ->addMatch('intend-space', 'space* | tab*', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('new-line', PHP_EOL, Matcher::FLAG_COUNT | Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('tree-prefix', 'prefix | middleware', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('prefix', '"prefix" whitespace prefix-str', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('prefix-str', 'str', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('middleware', '"middleware" whitespace middleware-list', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('middleware-list', 'str [ whitespace? "," whitespace? middleware-list space? ]', Matcher::FLAG_MAKE_NOTE | Matcher::FLAG_AS_ARRAY)
                    ->addMatch('space', '" "*')
                    ->addMatch('tab', "\"\t\"*")
                    ->addMatch('whitespace', '(space* | tab*)*')
                    ->addMatch('str', null, Matcher::FLAG_IS_STRING)
                    ->addMatch('route', 'intend-space? method whitespace url-path [route-attributes]? new-line?', Matcher::FLAG_NODE)
                    ->addMatch('method', 'str', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('url-path', 'str', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('route-attributes', [
                        'whitespace route-name',
                        'whitespace route-middleware',
                        'whitespace route-view',
                        'whitespace route-execute',
                    ], Matcher::FLAG_ONE_OF_THE | Matcher::FLAG_USE_MULTIPLE)
                    ->addMatch('route-name', '"name" name-str')
                    ->addMatch('name-str', 'str', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('route-middleware', '"middleware" middleware-list')
                    ->addMatch('route-view', '"view" view-str')
                    ->addMatch('view-str', 'str', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('route-execute', '"execute" controller-str controller-type method-str')
                    ->addMatch('controller-str', 'str', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('controller-type', '"::" | "->"', Matcher::FLAG_MAKE_NOTE)
                    ->addMatch('method-str', 'str', Matcher::FLAG_MAKE_NOTE);

            $parser = $matcher->buildParser();

            dump($matcher, $parser);
        }
    }
