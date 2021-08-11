<?php


namespace app\modules\api\v1\auth\services;


use app\exceptions\BadRequestException;
use app\modules\api\v1\auth\forms\LoginForm;
use app\modules\api\v1\user\models\User;
use yii\base\Exception;

class AuthService
{

    /**
     * @param $request
     * @return array
     * @throws BadRequestException
     * @throws Exception
     */
    public function login($request): array
    {
        $form = new LoginForm($request);
        if (!$form->validate()) {
            throw new BadRequestException($form->getErrors(), 'Ошибка валидации проверьте правильность введеных данных');
        }

        $user = User::find()->byEmail($form->email)->one();
        if (is_null($user)) {
            throw new BadRequestException([], 'Пользователь не найден');
        }

        if (!$user->validatePassword($form->password)) {
            throw new BadRequestException([], 'Пользователь не найден');
        }

        $user->generateAccessToken();

        return $user->authFields();
    }
}