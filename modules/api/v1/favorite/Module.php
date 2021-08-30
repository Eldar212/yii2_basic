<?php

namespace app\modules\api\v1\favorite;

use app\modules\core\modules\CoreModule;
use Yii;

class Module extends CoreModule
{
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\favorite\controllers';
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\favorite\commands';
        }

        Yii::setAlias('@apiV1_module_favorite', '@app/modules/api/v1/favorite');

        /**
         * @see DefaultController::actionAdd()
         */
        $app->getUrlManager()->addRules([
            'POST v1/favorite/<id:\d+>' => 'v1/favorite/default/add',
        ], false);
    }
}