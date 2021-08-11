<?php


namespace app\modules\api\v1\profile\services;

use app\exceptions\BadRequestException;
use app\modules\api\v1\profile\models\UserProfile;
use app\modules\api\v1\user\forms\UserCreateForm;


class UserProfileService
{
    /**
     * @param int $userId
     * @param UserCreateForm $form
     * @return UserProfile
     * @throws BadRequestException
     */
    public function create(int $userId, UserCreateForm $form): UserProfile
    {
        $userProfile = new UserProfile([
            'user_id' => $userId,
            'name' => $form->name,
            'middle_name' => $form->middle_name,
            'last_name' => $form->last_name,
            'phone' => $form->phone,
        ]);

        if (!$userProfile->validate() || !$userProfile->save()) {
            throw new BadRequestException($userProfile->getErrors(), 'Не удалось создать профиль для пользователя');
        }

        return $userProfile;
    }

    public function update($request): array
    {
        return ['profile_update'];
    }
}