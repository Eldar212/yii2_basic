<?php


namespace app\modules\api\v1\profile;


use app\modules\core\modules\CoreModule;
use Yii;

class Module extends CoreModule
{

    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\profile\controllers';
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\profile\commands';
        }

        Yii::setAlias('@apiV1_module_profile', '@app/modules/api/v1/profile');

        $app->getUrlManager()->addRules([
            'PUT v1/profile' => 'v1/profile/default/update',
        ], false);
    }
}