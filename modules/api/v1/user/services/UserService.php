<?php
namespace app\modules\api\v1\user\services;

use app\exceptions\BadRequestException;
use app\modules\api\v1\profile\services\UserProfileService;
use app\modules\api\v1\user\forms\UserCreateForm;
use app\modules\api\v1\user\models\User;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class UserService
{
    /** @var UserProfileService */
    protected $userProfileService;

    /**
     * UserService constructor.
     * @param UserProfileService $userProfileService
     */
    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }

    /**
     * @param array $request
     * @return User
     * @throws BadRequestException
     * @throws Exception
     * @throws Throwable
     * @throws \yii\base\Exception
     */
    public function create(array $request): User
    {
        $form = new UserCreateForm($request);

        if (!$form->validate()) {
            throw new BadRequestException($form->getErrors(), 'Форма заполнена неверно');
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User([
                'email' => $form->email,
                'password_hash' => Yii::$app->security->generatePasswordHash($form->password),
                'password_reset_token' => Yii::$app->security->generateRandomString(),
                'status' => User::STATUS_ACTIVE
            ]);

            if (!$user->validate() || !$user->save()) {
                throw new BadRequestException($user->getErrors(), 'Не удалось создать пользователя');
            }

            $this->userProfileService->create($user->id, $form);

            $transaction->commit();

            return $user;
        } catch (Throwable $e) {
            $transaction->rollBack();

            throw $e;
        }
    }

    /**
     * @param User $user
     * @param array $request
     * @return User
     * @throws BadRequestException
     */
    public function update(User $user, array $request): User
    {
        $user->userProfile->setAttributes($request);

        if (!$user->userProfile->validate()) {
            throw new BadRequestException($user->userProfile->getErrors(), 'Не удалось обновить пользователя');
        }

        if (!$user->userProfile->save()) {
            throw new BadRequestException($user->userProfile->getErrors(), 'Не удалось обновить пользователя');
        }

        $user->userProfile->refresh();

        return $user;
    }

    /**
     * @param int $id
     * @return User
     * @throws BadRequestException
     */
    public function getById(int $id): User
    {
        $user = User::find()->byId($id)->one();

        if (is_null($user)) {
            throw new BadRequestException([], 'Не удалось найти пользователя');
        }

        return $user;
    }

    /**
     * @return User[]
     */
    public function getList(): array
    {
        $activeDataProvider = new ActiveDataProvider([
            'query' => User::find()->byActive(),
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'attributes' => [
                    'arsen' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC]
                    ]
                ],
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'enableMultiSort' => true
            ]
        ]);

        return $activeDataProvider->getModels();
    }
}