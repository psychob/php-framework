<?php

    use PsychoB\Framework\Template\Engine\TemplateEngine;
    use PsychoB\Framework\Template\Generic\Block\ExtendsBlock;

    return [
        'engines' => [
            'template' => TemplateEngine::class,
        ],
        'blocks' => [
            'extends' => ExtendsBlock::class,
        ]
    ];
