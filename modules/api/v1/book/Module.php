<?php


namespace app\modules\api\v1\book;

use app\modules\api\v1\book\controllers\AuthorController;
use app\modules\api\v1\book\controllers\DefaultController;
use app\modules\core\modules\CoreModule;
use Yii;
use yii\base\Application;


class Module extends CoreModule
{

    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\book\controllers';
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\api\v1\book\commands';
        }

        Yii::setAlias('@apiV1_module_book', '@app/modules/api/v1/book');

        $app->getUrlManager()->addRules([
            /**
             * Добавление книги
             * @see DefaultController::actionCreate()
             */
            'POST v1/book/create' => 'v1/book/default/create',

            /**
             * Добавление автора книги
             * @see AuthorController::actionCreate()
             */
            'POST v1/author/add' => 'v1/book/author/create',

            'GET v1/book/<id:\d+>' => 'v1/book/default/get-by-id',


            'GET v1/book' => 'v1/book/default/list',

            /**
             * @see DefaultController::actionUpdate()
             */
            'PUT v1/book/<id:\d+>' => 'v1/book/default/update',

            /**
             * @see AuthorController::actionUpdate
             */
            'PUT v1/author/<id:\d+>' => 'v1/book/author/update',

            /**
             * Удаление автора книги
             * @see DefaultController::actionDelete()
             */
            'DELETE v1/book/<id:\d+>' => 'v1/book/default/delete',

            /**
             * Удаление автора книги
             * @see AuthorController::actionDelete()
             */
            'DELETE v1/author/<id:\d+>' => 'v1/book/author/delete',
        ], false);
    }
}