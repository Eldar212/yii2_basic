<?php

namespace app\modules\api\v1\auth\handlers;

use yii\web\UnauthorizedHttpException;

class HttpBearerAuth extends \yii\filters\auth\HttpBearerAuth
{
    public function authenticate($user, $request, $response)
    {
        try {
            $authenticate = parent::authenticate($user, $request, $response);
        } catch(\Throwable $e) {
            throw new UnauthorizedHttpException('Любое сообщение');
        }

        return $authenticate;
    }
}