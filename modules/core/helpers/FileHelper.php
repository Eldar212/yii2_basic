<?php

namespace app\modules\core\helpers;

use Yii;
use yii\base\Exception;

class FileHelper
{
    /**
     * @throws Exception
     */
    public static function getRandName($length = 10): string
    {
        return Yii::$app->security->generateRandomString($length);
    }
}