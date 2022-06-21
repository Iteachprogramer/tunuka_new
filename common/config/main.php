<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['gii'],
    'language' => 'uz',
    'name' => 'Tunuka',

    'components' => [
        'i18n' => [
            'translations' => [
                'site*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@soft/i18n/messages',
                    'fileMap' => [
                        'site' => 'site.php',
                    ],
                ],
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],
        'view' => [
            'class' => 'soft\web\View',
            'renderers' => [
                'blade' => [
                    'class' => '\cyneek\yii2\blade\ViewRenderer',
                    'cachePath' => '@common/runtime/blade_cache',
                ],
            ],
        ],
        'formatter' => [
            'class' => 'soft\i18n\Formatter',
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'softModel' => [
                    'class' => 'soft\gii\generators\model\Generator',
                ],
                'softAjaxCrud' => [
                    'class' => 'soft\gii\generators\crud\Generator',
                ],
            ]
        ]
    ]
];
