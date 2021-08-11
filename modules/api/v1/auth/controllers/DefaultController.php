<?php


namespace app\modules\api\v1\auth\controllers;


use app\exceptions\BadRequestException;
use app\modules\api\v1\auth\services\AuthService;
use app\modules\api\v1\user\models\User;
use app\modules\api\v1\user\services\UserService;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\web\Controller;

class DefaultController extends Controller
{
    /** @var AuthService */
    protected $authService;

    /** @var UserService */
    protected $userService;

    public function __construct($id, $module, AuthService $authService, UserService $userService, $config = [])
    {
        $this->authService = $authService;
        $this->userService = $userService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     * @throws BadRequestException
     * @throws Exception
     */
    public function actionLogin(): array
    {
        $request = Yii::$app->request->bodyParams;

        return $this->authService->login($request);
    }

    /**
     * @OA\Info(title="registrationAPI", version="1")
     */

    /**
     * @OA\Get(
     *     path="/api/resource.json",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */


    /**
     * @return User
     * @throws BadRequestException
     * @throws \yii\db\Exception
     * @throws \Throwable
     * @throws \Exception
     */
    public function actionRegistration(): User
    {
        $request = Yii::$app->request->bodyParams;

        return $this->userService->create($request);
    }
}