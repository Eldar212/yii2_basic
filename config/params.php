<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    // Swagger
    'swagger' => [
        // Директории или файлы для сканирования аннотации
        'scan' => [
            /** @see \app\modules\swagger\controllers\DefaultController */
            '@module_swagger/controllers',

            /** @see \app\modules\swagger\schemas */
            '@module_swagger/schemas',

            '@apiV1_module_auth',
        ],
    ],
];
