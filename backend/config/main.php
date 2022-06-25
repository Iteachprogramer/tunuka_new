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
    'name'=>'Admin',
    'bootstrap' => ['log'],
    'language' => 'uz',
    'homeUrl' => '/admin',
    'modules' => [
        'profilemanager' => [
            'class' => 'backend\modules\profilemanager\Module',
        ],
        'usermanager' => [
            'class' => 'backend\modules\usermanager\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-common',
            'baseUrl' => '/admin',
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-common', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-common',
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
                    'baseUrl' => '@web/adminLte3',
                    'js' => [
                        '/frontend/web/adminLte3/js/jquery.min.js'
                    ],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@web/adminLte3',
                    'css' => [
                        '/frontend/web/adminLte3/css/fontawesome-free/css/all.min.css',
                        '/frontend/web/adminLte3/css/adminlte.min.css',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@web/adminLte3',
                    'css' => [
                        '/frontend/web/adminLte3/css/fontawesome-free/css/all.min.css',
                        '/frontend/web/adminLte3/css/adminlte.min.css',
                    ],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@web/adminLte3',
                    'js' => [
                        '/frontend/web/adminLte3/js/bootstrap.bundle.min.js',
                    ],
                ],
            ],
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
