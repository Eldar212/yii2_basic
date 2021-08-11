<?php

namespace app\modules\api\v1\user\controllers;

use app\modules\api\v1\auth\base\BearerAuthController;
use app\modules\api\v1\user\services\UserService;
use \app\modules\api\v1\user\models\User;
use \app\exceptions\BadRequestException;
use Yii;

class DefaultController extends BearerAuthController
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
     * @throws BadRequestException
     */
    public function actionUpdate(): User
    {
        $user = Yii::$app->user->identity;
        $request = Yii::$app->request->bodyParams;

        return $this->userService->update($user, $request);
    }

    /**
     * @throws BadRequestException
     */
    public function actionDelete(int $id): bool
    {
        return $this->userService->delete($id);
    }

    /**
     * @throws BadRequestException
     */
    public function actionGetById(int $id): User
    {
        return $this->userService->getById($id);
    }

    /**
     * @return User[]
     */
    public function actionList(): array
    {
        return $this->userService->getList();
    }
}