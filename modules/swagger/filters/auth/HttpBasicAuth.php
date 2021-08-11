<?php

namespace app\modules\swagger\filters\auth;

use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class HttpBasicAuth extends \yii\filters\auth\HttpBasicAuth
{
    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        try {
            return parent::beforeAction($action);
        } catch(UnauthorizedHttpException $e) {
            throw new BadRequestHttpException('Unauthorized', 401);
        }
    }
}
