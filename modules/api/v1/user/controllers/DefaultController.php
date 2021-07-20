<?php

namespace app\modules\api\v1\user\controllers;

use app\modules\api\v1\user\services\UserService;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * DefaultController constructor.
     * @param $id
     * @param $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct($id, $module, UserService $userService, array $config = [])
    {
        $this->userService = $userService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        $request = Yii::$app->request->bodyParams;

        return $this->userService->create($request);
    }

    public function actionUpdate(): array
    {
        $request = Yii::$app->request->bodyParams;

        return $this->userService->update($request);
    }

    public function actionDelete(): array
    {
        return ['delete'];
    }

    public function actionGetById(): array
    {
        return ['get-by-id'];
    }

    public function actionList(): array
    {
        return ['list'];
    }
}