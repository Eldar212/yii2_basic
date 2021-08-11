<?php

namespace app\modules\swagger\controllers;

use app\modules\swagger\actions\SwaggerSchemaRender;
use app\modules\swagger\actions\SwaggerUIRenderer;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @OA\Info(
 *    version="1.0",
 *    title="Документация Basic Api"
 * ),
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    in="header",
 *    name="X-Auth-Token",
 *    type="apiKey",
 * ),
 * @OA\Server(
 *    url="http://api.basic.ua",
 *    description="Basic",
 * )
 */
class DefaultController extends Controller
{
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => \yii\filters\auth\HttpBasicAuth::class,
//            'auth' => function($username, $password) {
//                if($username === 'swagger' && $password === 'Swag$ger!_00') {
//                    return new User();
//                }
//
//                return null;
//            },
//        ];
//
//        return $behaviors;
//    }

    public function actions()
    {
        return [
            'index' => [
                'class' => SwaggerUIRenderer::class,
                'restUrl' => Url::to(['schema']),
            ],
            'schema' => [
                'class' => SwaggerSchemaRender::class,
                'scanDir' => array_map(
                    function($dir) {
                        if(isset($dir[0]) && $dir[0] === '@') {
                            $dir = Yii::getAlias($dir);
                        }

                        return $dir;
                    },
                    Yii::$app->params['swagger']['scan']
                ),
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return bool
     */
    public function actionDropCache(): bool
    {
        return Yii::$app->cache->delete('api-swagger-cache');
    }
}
