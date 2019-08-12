<?php
    //
    // psychob/framework
    // (c) 2019 RGB Lighthouse <https://rgblighthouse.pl>
    // (c) 2019 Andrzej Budzanowski <kontakt@andrzej.budzanowski.pl>
    //

    namespace Tests\PsychoB\Framework\Unit\Template\Engine\SimpleTemplate;

    use PsychoB\Framework\Template\Engine\SimpleTemplate\SimpleTemplateEngine;
    use PsychoB\Framework\Testing\Traits\EnableFrameworkConfigurationInTestCaseTrait;
    use PsychoB\Framework\Testing\Traits\EnableResolveInTestCaseTrait;
    use PsychoB\Framework\Testing\UnitTestCase;

    class SimpleTemplateEngineTest extends UnitTestCase
    {
        use EnableResolveInTestCaseTrait, EnableFrameworkConfigurationInTestCaseTrait;

        /** @var SimpleTemplateEngine */
        protected $tpl;

        protected function setUp(): void
        {
            parent::setUp();

            $this->tpl = $this->resolve(SimpleTemplateEngine::class);
        }

        public function provideExpression(): array
        {
            return [
                // nothing special
                ['', ''],
                ['abc def', 'abc def'],

                // comments
                ['', '{{* full comment *}}'],
                ['', '{{* full *}}{{* comment *}}'],
                [' ', '{{* full *}} {{* comment *}}'],
                ['', '{{+ {{* full *}} {{* comment *}} +}}'],

                // simple expression
                ['abc', '{{"abc"}}'],
                ['true', '{{ true }}'],
                ['true', '{{ true}}'],
                ['true', '{{true }}'],
                ['6', '{{4 + 2}}'],
                ['6', '{{4 + 1 + 1}}'],
                ['8', '{{4 * 2}}'],
                ['2', '{{4 / 2}}'],
                ['21', '{{7 * (4 + 5) / 3}}'],
                ['6', '{{2 + 2 * 2}}'],
                ['8', '{{(2 + 2) * 2}}'],
                ['256', '{{(8 * (2 + 2)) * 8}}'],
                ['256', '{{((8 * (2 + 2)) * 8)}}'],
                ['10', '{{2 + 2 * 8 / 2}}'],

                // different whitespace in variable
                ['42', '{{$abc}}', ['abc' => 42,]],
                ['42', '{{ $abc}}', ['abc' => 42,]],
                ['42', '{{$ abc}}', ['abc' => 42,]],
                ['42', '{{$abc }}', ['abc' => 42,]],
                ['42', '{{ $abc }}', ['abc' => 42,]],
                ['42', '{{ $ abc }}', ['abc' => 42,]],
                [' 42', ' {{$abc}}', ['abc' => 42,]],
                ['42 ', '{{$abc}} ', ['abc' => 42,]],
                [' 42 ', ' {{$abc}} ', ['abc' => 42,]],

                // if blocks
                ['1', '{{if true}}1{{/if}}'],
                ['' , '{{if false}}1{{/if}}'],
                ['1', '{{if true}}1{{else}}0{{/if}}'],
                ['0', '{{if false}}1{{else}}0{{/if}}'],
                ['1', '{{ if  true  }}1{{ /if}}'],
                ['' , '{{ if  false }}1{{ /if  }}'],
                ['1', '{{ if  true  }}1{{else}}0{{/if }}'],
                ['0', '{{ if  false }}1{{else}}0{{/if  }}'],
            ];
        }

        /** @dataProvider provideExpression */
        public function testExpression(string $out, string $in, array $args = []): void
        {
            $this->assertSame($out, $this->tpl->execute($in, $args));
        }
    }
