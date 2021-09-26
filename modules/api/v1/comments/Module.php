<?php

namespace app\modules\api\v1\comments;

use app\modules\core\modules\CoreModule;
use Yii;
use yii\base\Application;

class Module extends CoreModule
{

    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\comments\controllers';
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\comments\commands';
        }

        Yii::setAlias('@apiV1_module_comments', '@app/modules/api/v1/comments');

        $app->getUrlManager()->addRules([
            'GET /book-comments-list/<id:\d+>' => 'v1/comments/default/getList',

            'GET /comment/<id:\d+>' => 'v1/comments/default/getById',

            'POST /comment/' => 'v1/comments/default/create',

            'DELETE /comment/<id:\d+>' => 'v1/comments/default/delete',
        ]);
    }
}