<?php

namespace app\helpers;

use Yii;

class RequestHelper
{

    public static function getBodyParam()
    {
        return Yii::$app->request->bodyParams;
    }
}