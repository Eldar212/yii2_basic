<?php

namespace app\modules\api\v1\book\controllers;

use app\exceptions\BadRequestException;
use app\modules\api\v1\auth\base\BearerAuthController;
use app\modules\api\v1\book\models\BookAuthor;
use app\modules\api\v1\book\services\AuthorService;
use app\modules\api\v1\auth\helpers\AccessManager;
use app\helpers\RequestHelper;
use Throwable;
use yii\db\StaleObjectException;

class AuthorController extends BearerAuthController
{
    /**
     * @var AuthorService
     */
    protected AuthorService $authorService;

    public function __construct($id, $module, AuthorService $authorService, $config = [])
    {
        $this->authorService = $authorService;

        parent::__construct($id, $module, $config);
    }

    public function actionCreate(): BookAuthor
    {
        $request = RequestHelper::getBodyParams();

        return $this->authorService->create($request);
    }

    public function actionUpdate($id)
    {
        $request = RequestHelper::getBodyParams();

        return $this->authorService->update($id, $request);
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     * @throws BadRequestException
     */
    public function actionDelete($id): string
    {
        $request = RequestHelper::getBodyParams();

        return $this->authorService->delete($id);
    }

    public function actionPinBook()
    {
        $request = RequestHelper::getBodyParams();
        return $this->authorService->pinBook($request);
    }
}