<?php


namespace app\services;


use app\models\User;
use yii\web\BadRequestHttpException;
use app\components\securityHelper;

class UserService
{
    public function createUser(array $request)
    {
        $form = new UserCreateForm($request);

        if (!$form->validate()) {
            throw new BadRequestHttpException('Ошибка валидации при создании пользователя');
        }

        $user = User::find()->byEmail($form->email)->one();

        $user = new User([
            'email' => $form->email,
            'password_hash' => User::generatePasswordHash($form->password),
        ]);
    }
}