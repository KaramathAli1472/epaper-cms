<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'epaper-cms-2025-ali-hyderabad-secret-key-123456789',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                    'logVars' => [],
                ],
            ],
        ],
        'db' => $db,

        // ⬇️ Bootstrap 5 assets yahan add kiye
        'assetManager' => [
            'appendTimestamp' => true,
            'basePath' => '@webroot/assets',
            'baseUrl'  => '@web/assets',
            'bundles' => [
                // Purana Bootstrap disable
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                    'js'  => [],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'css' => [],
                    'js'  => [],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [],
                    'js'  => [],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'css' => [],
                    'js'  => [],
                ],

                // Bootstrap 5 enable
                'yii\bootstrap5\BootstrapAsset' => [
                    'class' => 'yii\bootstrap5\BootstrapAsset',
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'class' => 'yii\bootstrap5\BootstrapPluginAsset',
                ],

                // jQuery bundle (agar chahiye)
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
                    ],
                ],
            ],
        ],

        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
