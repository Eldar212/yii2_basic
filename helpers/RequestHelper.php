<?php

namespace app\helpers;

use Yii;

class RequestHelper
{

    public static function getBodyParams()
    {
        return Yii::$app->request->bodyParams;
    }

    public static function getPostParams()
    {
        return Yii::$app->request->post();
    }
}