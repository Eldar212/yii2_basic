<?php

    return [
        'id' => 'basiс',
        'controllerNamespace' => 'app\commands',
        'components' => [],
        'controllerMap' => [
            'migrate' => [
                'class' => \yii\console\controllers\MigrateController::class,
                'migrationPath' => [
                    '@apiV1_module_user/migrations',
                    '@apiV1_module_profile/migrations',
//                    '@module_core/migrations',
                ],
            ],
        ],
    ];
