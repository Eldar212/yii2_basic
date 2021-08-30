<?php

namespace app\modules\api\v1\auth\filters;

use yii\web\UnauthorizedHttpException;

class CompositeAuth extends \yii\filters\auth\CompositeAuth
{
    public function handleFailure($response)
    {
        try {
            parent::handleFailure($response);
        } catch (UnauthorizedHttpException $e) {
            throw new UnauthorizedHttpException('Токен не указан');
        }
    }
}