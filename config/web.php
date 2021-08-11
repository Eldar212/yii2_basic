<?php
    use app\handlers\ErrorHandler;
    use yii\web\Response;

    return [
        'id' => 'basic',
        'defaultRoute' => 'default/index',
        'bootstrap' => [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => ['application/json' => Response::FORMAT_JSON],
            ],
        ],
        'components' => [
            'assetManager' => null,
            'request' => [
                'enableCookieValidation' => false,
                'enableCsrfValidation' => false,
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser',
                    'multipart/form-data' => 'yii\web\MultipartFormDataParser',
                ],
            ],
            'response' => [
                'formatters' => [
                    \yii\web\Response::FORMAT_JSON => [
                        'class' => 'yii\web\JsonResponseFormatter',
                        'prettyPrint' => YII_DEBUG, // используем "pretty" в режиме отладки
                        'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    ],
                ],
            ],
            'user' => [
                'identityClass' => 'app\modules\api\v1\user\models\User',
            ],
            'errorHandler' => [
                'class' => ErrorHandler::class,
            ],
        ],
    ];