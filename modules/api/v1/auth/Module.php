<?php


namespace app\modules\api\v1\auth;


use app\modules\api\v1\auth\controllers\DefaultController;
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
            $this->controllerNamespace = 'app\modules\api\v1\auth\controllers';
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\auth\commands';
        }

        Yii::setAlias('@apiV1_module_auth', '@app/modules/api/v1/auth');

        $app->getUrlManager()->addRules([
            /**
             * Получение access_token
             * @see DefaultController::actionLogin()
             */
            'POST v1/auth/login' => 'v1/auth/default/login',

            /**
             *  @see DefaultController::actionRegistration()
             */
            'POST v1/auth/registration' => 'v1/auth/default/registration',
        ], false);
    }
}