<?php

namespace app\modules\api\v1\auth\filters;

use yii\web\UnauthorizedHttpException;

class HttpBearerAuth extends \yii\filters\auth\HttpBearerAuth
{
    public function handleFailure($response)
    {
        try {
            parent::handleFailure($response);
        } catch (UnauthorizedHttpException $e) {
            throw new UnauthorizedHttpException('Токен неверный');
        }
    }
}