<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Template\Engine;

    use PsychoB\Framework\Template\Engine\TemplateEngine;
    use PsychoB\Framework\Testing\Traits\EnableResolveInTestCaseTrait;
    use PsychoB\Framework\Testing\UnitTestCase;

    class TemplateEngineTest extends UnitTestCase
    {
        use EnableResolveInTestCaseTrait;

        /** @var TemplateEngine */
        protected $tpl;

        protected function setUp(): void
        {
            parent::setUp();

            $this->tpl = $this->resolve(TemplateEngine::class);
        }

        public function testFileWithoutSpecialBlocks()
        {
            $testStr = <<<OUTPUT
<!doctype html>
<html>
<head></head>
<body></body>
</html>
OUTPUT;

            $this->assertSame($testStr, $this->tpl->execute($testStr));
        }

        public function provideSimpleExpressions()
        {
            return [
//                [' ', ' ', []],
//                ['42', '{{$abc}}', ['abc' => 42]],
//                [' 42', ' {{$abc}}', ['abc' => 42]],
//                ['42 ', '{{$abc}} ', ['abc' => 42]],
//                [' 42 ', ' {{$abc}} ', ['abc' => 42]],
//                [' 42 ', ' {{ $abc}} ', ['abc' => 42]],
//                [' 42 ', ' {{$abc }} ', ['abc' => 42]],
//                ['42', '{{$abc.def}}', ['abc' => ['def' => 42]]],
//                ['42', '{{$abc.def.ghi}}', ['abc' => ['def' => ['ghi' => 42]]]],
//                ['42', "{{\$abc\t.\tdef}}", ['abc' => ['def' => 42]]],
                ['42', '{{$abc .def}}', ['abc' => ['def' => 42]]],
//                ['42', '{{$abc. def}}', ['abc' => ['def' => 42]]],
//                ['42', '{{$abc . def }}', ['abc' => ['def' => 42]]],
//                ['&lt;&gt;', '{{$abc}}', ['abc' => '<>']],
//                ['<>', '{{$abc|raw}}', ['abc' => '<>']],
//                ['', '{{* foo bar *}}'],
//                [' ', '{{* foo bar *}} {{* baz faz *}}'],
//                ['', '{{+ {{* foo bar *}} {{* baz faz *}}   +}}'],
//                ['', '{{+ {{* foo bar {{+ *}} {{* +}} baz faz *}}   +}}'],
//                ['', '{{+ foo bar +}}'],
//                [' ', '{{+ foo bar +}} {{+ baz faz +}}'],
            ];
        }

        /** @dataProvider provideSimpleExpressions */
        public function testSimpleExpressions(string $out, string $in, array $variables = []): void
        {
            $this->assertSame($out, $this->tpl->execute($in, $variables));
        }
    }
