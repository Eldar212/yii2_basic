<?php

namespace app\modules\api\v1;

use app\modules\core\modules\CoreModule;
use Yii;

/**
 * Модуль первой версии Api
 *
 * Class Module
 * @package app\modules\api\v1
 */
class Module extends CoreModule
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\controllers';
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\commands';
        }

        Yii::setAlias('@apiV1', '@app/modules/api/v1');

        $app->getUrlManager()->addRules([], false);
    }

    /**
     * @return array
     */
    public function getChildModules(): array
    {
        return [
            /** @see \app\modules\api\v1\user\Module */
            'user' => [
                'class' => 'app\modules\api\v1\user\Module',
            ],
            'profile' => [
                'class' => 'app\modules\api\v1\profile\Module',
            ],
        ];
    }
}