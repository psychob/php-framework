<?php

    use PsychoB\Framework\Template\Engine\SimpleTemplate\SimpleTemplateEngine;
    use PsychoB\Framework\Template\Generic\Block\ExtendsBlock;
    use PsychoB\Framework\Template\Generic\Block\IfBlock;
    use PsychoB\Framework\Template\Generic\Filter\RawFilter;

    return [
        'engines' => [
            'template' => SimpleTemplateEngine::class,
        ],
        'blocks' => [
            'extends' => ExtendsBlock::class,
            'if' => IfBlock::class,
        ],
        'filters' => [
            'raw' => RawFilter::class,
        ],
    ];
