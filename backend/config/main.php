<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'uz',
    'homeUrl' => '/admin',
    'modules' => [
        'smsmanager' => [
            'class' => 'backend\modules\smsmanager\Module',
        ],
        'region-manager' => [
            'class' => 'backend\modules\regionmanager\RegionModule',
        ],
        'profilemanager' => [
            'class' => 'backend\modules\profilemanager\Module',
        ],
        'usermanager' => [
            'class' => 'backend\modules\usermanager\Module',
        ],
        'translate-manager' => [
            'class' => 'backend\modules\translationmanager\TranslationManager',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],

    ],
    'components' => [
        'sms' => [
            'class' => 'backend\modules\smsmanager\models\Sms'
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-sugar', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => '/admin',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],

        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@homeUrl/template/adminlte3/base-assets',
                    'js' => ['js/jquery.min.js']
                ],

                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@homeUrl/template/adminlte3/base-assets',
                    'css' => [
                        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
                        'fontawesome-free/css/all.min.css',
                        'css/adminlte.min.css',
                    ]
                ],

                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@homeUrl/template/adminlte3/base-assets',
                    'js' => ['js/bootstrap.bundle.min.js',]
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => [],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [],
                ],
            ]
        ],

    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['admin'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '',
                    'basePath' => '@frontend/web',
                    'path' => 'files/global',
                    'name' => 'Fayllar'
                ],

            ],

        ]
    ],
    'params' => $params,
];
