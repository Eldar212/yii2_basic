<?php

namespace app\modules\swagger;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Модуль документации
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\swagger\controllers';

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@module_swagger', '@app/modules/swagger');

        if($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\swagger\commands';
        }

        /** @var Application $app */
        $app->getUrlManager()->addRules([
            'GET swagger'            => 'swagger/default/index',
            'GET swagger/schema'     => 'swagger/default/schema',
            'GET swagger/drop-cache' => 'swagger/default/drop-cache',
        ], false);
    }
}
