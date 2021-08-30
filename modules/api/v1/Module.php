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
            /** @see \app\modules\api\v1\auth\Module */
            'auth' => [
                'class' => 'app\modules\api\v1\auth\Module',
            ],

            /** @see \app\modules\api\v1\user\Module */
            'user' => [
                'class' => 'app\modules\api\v1\user\Module',
            ],

            /** @see \app\modules\api\v1\profile\Module */
            'profile' => [
                'class' => 'app\modules\api\v1\profile\Module',
            ],

            /** @see \app\modules\api\v1\book\Module */
            'book' => [
                'class' => 'app\modules\api\v1\book\Module',
            ],

            /** @see \app\modules\api\v1\favorite\Module */
            'favorite' => [
                'class' => 'app\modules\api\v1\favorite\Module',
            ],
        ];
    }
}