<?php


namespace app\modules\api\v1\profile\controllers;


use app\modules\api\v1\profile\services\UserProfileService;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @var UserProfileService
     */
    protected $profileService;

    public function __construct($id, $module, UserProfileService $profileService, $config = [])
    {
        $this->profileService = $profileService;

        parent::__construct($id, $module, $config);
    }

    public function actionUpdate(): array
    {
        $request = Yii::$app->request->bodyParams;

        return $this->profileService->update($request);
    }
}