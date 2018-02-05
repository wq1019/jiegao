<?php

/**
 * 模版最终为 $template['theme_namespace'] . '::' . $templateType .'.' . $template['templates'][$templateType]['file_name'];
 * 例如 默认单页模板 最终为 theme::page.default.
 */
return [

    'theme_namespace' => 'theme',

    'current_theme_path' => resource_path('views/jiegao'),
    'mobile'             => resource_path('views/mobile'),

    'templates' => [

        'page' => [
            [
                'file_name' => 'default',
                'title'     => '默认单页模板',
                'default'   => true,
            ],
        ],
        'list' => [
            [
                'file_name' => 'default',
                'title'     => '默认列表模板',
                'default'   => true,
            ],
            [
                'file_name' => 'product',
                'title'     => '产品列表模板',
            ],
        ],
        'content' => [
            [
                'file_name' => 'default',
                'title'     => '默认正文模板',
                'default'   => true,
            ], [
                'file_name' => 'product',
                'title'     => '产品正文模板',
                'default'   => true,
            ],
        ],
        'search' => [
            [
                'file_name' => 'search',
                'title'     => '默认搜索模板',
                'default'   => true,
            ],
        ],
    ],
];
