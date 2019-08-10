<?php

    use PsychoB\Framework\Template\Engine\TemplateEngine;
    use PsychoB\Framework\Template\Generic\Filter\RawFilter;

    return [
        'engines' => [
            'template' => TemplateEngine::class,
        ],
        'blocks' => [
            'extends' => ExtendsBlock::class,
        ],
        'filters' => [
            'raw' => RawFilter::class,
        ],
    ];
