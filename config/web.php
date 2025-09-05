<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset' ,
        '@uploads' => dirname(__DIR__) . '/web/uploads',
        '@uploadsUrl' => '/uploads',
    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/views/adminlte',

                ],
            ],
        ],
        'assetManager' => [
            'linkAssets' => false, 
            'forceCopy' => YII_DEBUG, 
            'appendTimestamp' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@bower/jquery/dist',
                    'js' => ['jquery.min.js']
                ],
                'yii\bootstrap5\BootstrapAsset' => [
                    'sourcePath' => '@bower/bootstrap/dist',
                    'css' => ['css/bootstrap.min.css'],
                    'js' => ['js/bootstrap.bundle.min.js']
                ],
                'rmrevin\yii\fontawesome\AssetBundle' => [
                    'sourcePath' => '@bower/font-awesome',
                    'css' => ['css/font-awesome.min.css']
                ],
                'dmstr\adminlte\web\AdminLteAsset' => [
                    'sourcePath' => '@vendor/almasaeed2010/adminlte',
                    'css' => [
                        'dist/css/adminlte.min.css',
                        'plugins/fontawesome-free/css/all.min.css'
                    ],
                    'js' => [
                        'dist/js/adminlte.min.js'
                    ],
                    'depends' => [
                        'yii\web\YiiAsset',
                        'yii\bootstrap5\BootstrapAsset',
                    ]
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => '4rAKJwxAmDrzQnnBtXiMGLxHUFWxXC0_',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'currencyCode' => 'RUB',
            'locale' => 'ru-RU', 
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_ENV_DEV ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'admin/films' => 'film/index',
                'admin/sessions' => 'session/index',
            ],
        ],
    ],
    'params' =>  $params
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;