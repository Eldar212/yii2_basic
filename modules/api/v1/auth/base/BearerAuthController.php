<?php


namespace app\modules\api\v1\auth\base;

use app\modules\api\v1\auth\filters\CompositeAuth;
use app\modules\api\v1\auth\filters\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

abstract class BearerAuthController extends Controller
{
    /**
     * @return array
     */

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'authenticator' => [
                    'class'       => CompositeAuth::class,
//                    'except'      => [
//                        'update'
//                    ],
                    'authMethods' => [
                        HttpBearerAuth::class
                    ]
                ]
            ]
        );
    }
}