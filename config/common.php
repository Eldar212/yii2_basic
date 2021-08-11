<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/local/params.php')
);

$common = [
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'timezone' => 'Europe/Moscow',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'default/index',
    'bootstrap' => [
        'log',
        'v1',
        'swagger'
    ],
    'modules' => [
        'v1' => ['class' => 'app\modules\api\v1\Module'],
        'swagger' => ['class' => 'app\modules\swagger\Module'],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@logs' => dirname(__DIR__) . '/logs',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'default/index',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ]
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ]
    ],
    'params' => $params
];

if(YII_ENV_DEV) {
    $common['bootstrap'][] = 'debug';
    $common['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $common['bootstrap'][] = 'gii';
    $common['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $common;
