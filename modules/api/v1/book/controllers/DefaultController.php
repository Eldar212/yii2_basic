<?php


namespace app\modules\api\v1\book\controllers;

use app\exceptions\BadRequestException;
use app\modules\api\v1\auth\base\BearerAuthController;
use app\modules\api\v1\auth\helpers\AccessManager;
use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\book\services\BookService;
use app\helpers\RequestHelper;
use Throwable;
use yii\db\StaleObjectException;

class DefaultController extends BearerAuthController
{
    /**
     * @var mixed
     */
    protected $bookService;

    public function __construct($id, $module, BookService $bookService, $config = [])
    {
        $this->bookService = $bookService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @throws Throwable
     * @throws BadRequestException
     */
    public function actionCreate(): Book
    {
        $request = RequestHelper::getBodyParam();
        $user = AccessManager::getUser();

        return $this->bookService->create($user, $request);
    }

    /**
     * @param int $id
     * @return Book|array|null
     * @throws BadRequestException
     */
    public function actionUpdate(int $id)
    {
        $user = AccessManager::getUser();
        $request = RequestHelper::getBodyParam();

        return $this->bookService->update($user, $id, $request);
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): string
    {
        $user = AccessManager::getUser();
        return $this->bookService->delete($user, $id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function actionGetById(int $id)
    {
        $user = AccessManager::getUser();

        return $this->bookService->getById($id);
    }

    /**
     * @return Book[]
     */
    public function actionList(): array
    {
        $user = AccessManager::getUser();

        return $this->bookService->getList();
    }
}