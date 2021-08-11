<?php

namespace app\modules\api\v1\auth\helpers;

use Yii;
use yii\web\IdentityInterface;

class AccessManager
{
    public static function getUser(): ?IdentityInterface
    {
        return Yii::$app->user->identity;
    }
}