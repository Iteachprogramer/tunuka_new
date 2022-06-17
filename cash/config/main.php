<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-cash',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'cash\controllers',
    'bootstrap' => ['log'],
    'language' => 'uz',
    'name'=>'Kassa',
    'homeUrl' => '/cash',
    'modules' => [
        'profilemanager' => [
            'class' => 'cash\modules\profilemanager\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-cash',
            'baseUrl' => '/cash',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-common', 'httpOnly' => true],
        ],
        'session' => [
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
            'baseUrl' => '/cash',
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

    'params' => $params,
];
