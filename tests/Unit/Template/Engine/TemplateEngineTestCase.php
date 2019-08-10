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
    use PsychoB\Framework\Testing\Traits\EnableResolveInTestCaseTrait;
    use PsychoB\Framework\Testing\Traits\EnableSeparateConfigurationInTestCaseTrait;
    use PsychoB\Framework\Testing\UnitTestCase;

    class TemplateEngineTestCase extends UnitTestCase
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
    }
