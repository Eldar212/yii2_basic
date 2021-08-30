<?php

namespace app\modules\api\v1\favorite\controllers;

use app\modules\api\v1\auth\base\BearerAuthController;
use app\helpers\RequestHelper;
use app\modules\api\v1\auth\helpers\AccessManager;
use app\modules\api\v1\favorite\services\FavoritesService;


class DefaultController extends BearerAuthController
{

    /**
     * @var mixed
     */
    protected $favoriteService;

    public function __construct($id, $module, FavoritesService $favoriteService, $config = [])
    {
        $this->favoriteService = $favoriteService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @throws \Throwable
     */
    public function actionAdd($id)
    {
        $user = AccessManager::getUser();
        return $this->favoriteService->add($id, $user);
    }
}