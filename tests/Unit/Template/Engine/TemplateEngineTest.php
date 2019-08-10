<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Template\Engine;

    use PsychoB\Framework\Template\Engine\TemplateEngine;
    use PsychoB\Framework\Template\Generic\Block\ExtendsBlock;
    use PsychoB\Framework\Template\Generic\Filter\RawFilter;
    use PsychoB\Framework\Testing\Traits\EnableSeparateConfigurationInTestCaseTrait;
    use PsychoB\Framework\Testing\Traits\EnableResolveInTestCaseTrait;
    use PsychoB\Framework\Testing\UnitTestCase;

    class TemplateEngineTest extends UnitTestCase
    {
        use EnableResolveInTestCaseTrait, EnableSeparateConfigurationInTestCaseTrait;

        /** @var TemplateEngine */
        protected $tpl;

        protected function setUp(): void
        {
            parent::setUp();

            $this->configSet([
                'template' => [
                    'blocks' => [
                        'extends' => ExtendsBlock::class,
                        'if' => IfBlock::class,
                        'assign' => AssignBlock::class,
                    ],
                    'filters' => [
                        'raw' => RawFilter::class,
                    ],
                ],
            ]);
            $this->tpl = $this->resolve(TemplateEngine::class);
        }

        public function testEmptyString()
        {
            $this->assertSame('', $this->tpl->execute(''));
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

        public function provideExpressions(): array
        {
            return [
                // variables
                ['42', '{{$abc}}', ['abc' => 42]],
                [' 42', ' {{$abc}}', ['abc' => 42]],
                ['42 ', '{{$abc}} ', ['abc' => 42]],
                [' 42 ', ' {{$abc}} ', ['abc' => 42]],
                [' 42 ', ' {{ $abc}} ', ['abc' => 42]],
                [' 42 ', ' {{$abc }} ', ['abc' => 42]],
                ['42', '{{$abc.def}}', ['abc' => ['def' => 42]]],
                ['42', '{{$abc.def.ghi}}', ['abc' => ['def' => ['ghi' => 42]]]],
                ['42', "{{\$abc\t.\tdef}}", ['abc' => ['def' => 42]]],
                ['42', '{{$abc .def}}', ['abc' => ['def' => 42]]],
                ['42', '{{$abc. def}}', ['abc' => ['def' => 42]]],
                ['42', '{{$abc . def }}', ['abc' => ['def' => 42]]],
                ['&lt;&gt;', '{{$abc}}', ['abc' => '<>']],

                // variables with filters
                ['<>', '{{$abc|raw}}', ['abc' => '<>']],

                // comments
                ['', '{{* foo bar *}}'],
                [' ', '{{* foo bar *}} {{* baz faz *}}'],
                ['', '{{+ {{* foo bar *}} {{* baz faz *}}   +}}'],
                ['', '{{+ {{* foo bar {{+ *}} {{* +}} baz faz *}}   +}}'],
                ['', '{{+ foo bar +}}'],
                [' ', '{{+ foo bar +}} {{+ baz faz +}}'],

                // if block
                ['1', '{{if true}}1{{/if}}'],
                ['', '{{if false}}1{{/if}}'],

                // assign block
                ['4', '{{assign name="var" value=4}}{{$var}}', ['var' => 3]],
                ['4', '{{assign $var=4}}{{$var}}', ['var' => 3]],
            ];
        }

        /** @dataProvider provideExpressions */
        public function testExpression(string $out, string $in, array $args = []): void
        {
            $this->assertSame($out, $this->tpl->execute($in, $args));
        }
    }
