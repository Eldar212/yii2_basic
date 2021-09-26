<?php

namespace app\modules\api\v1\comments\controllers;

use app\helpers\RequestHelper;
use app\modules\api\v1\auth\base\BearerAuthController;
use app\modules\api\v1\auth\helpers\AccessManager;
use app\modules\api\v1\comments\services\CommentService;

class DefaultController extends BearerAuthController
{
    protected CommentService $commentService;

    public function __construct($id, $module, CommentService $commentService, $config = [])
    {
        $this->commentService = $commentService;
        parent::__construct($id, $module, $config);
    }

    public function actionCreate($id): string
    {
        $request = RequestHelper::getPostParams();
        $user = AccessManager::getUser();

        return 'comment';
    }
}