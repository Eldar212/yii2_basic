<?php


namespace app\modules\api\v1\user\services;

use app\exceptions\BadRequestException;
use app\modules\api\v1\profile\services\UserProfileService;
use app\modules\api\v1\user\forms\UserCreateForm;
use app\modules\api\v1\user\models\User;
use Throwable;
use Yii;
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
     * @return array
     * @throws BadRequestException
     * @throws Throwable
     * @throws Exception
     */
    public function create(array $request): array
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

            $userProfile = $this->userProfileService->create($user->id, $form);

            $transaction->commit();

            return [
                'user' => $user,
                'user_profile' => $userProfile
            ];
        } catch (Throwable $e) {
            $transaction->rollBack();

            throw $e;
        }
    }

    public function update($request)
    {
        return [
            'action' => 'update',
            'request' => $request
        ];
    }
}