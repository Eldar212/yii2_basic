<?php

namespace app\modules\api\v1\user;

use app\modules\core\modules\CoreModule;
use Yii;

class Module extends CoreModule
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\user\controllers';
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\user\commands';
        }

        Yii::setAlias('@apiV1_module_user', '@app/modules/api/v1/user');

        $app->getUrlManager()->addRules([
            'POST v1/user' => 'v1/user/default/create',
            'PUT v1/user' => 'v1/user/default/update',
            'DELETE v1/user/<id:\d+>' => 'v1/user/default/delete',
            'GET v1/user/<id:\d+>' => 'v1/user/default/get-by-id',
            'GET v1/user' => 'v1/user/default/list',
        ], false);
    }
}