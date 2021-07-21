<?php


namespace app\modules\api\v1\user\forms;

use app\modules\api\v1\user\models\User;
use \app\modules\api\v1\profile\models\UserProfile;
use yii\base\Model;

class UserCreateForm extends Model
{
    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var string */
    public $name;

    /** @var string */
    public $middle_name;

    /** @var string */
    public $last_name;

    /** @var string */
    public $phone;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            [['email', 'password', 'name', 'middle_name', 'last_name','phone'], 'required'],
            [['email', 'password', 'name', 'middle_name', 'last_name','phone'], 'string'],
            [['email', 'password', 'name', 'middle_name', 'last_name','phone'], 'trim'],
            [['email'], 'email'],
            ['email', 'validateEmail'],
            ['phone', 'validatePhone'],
            [
                'password',
                'match',
                'pattern' => '/^(?=^.{6,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',
                'message' => 'Пароль должен быть не менее 6 символов, а также содержать цифры (0-9), латинские буквы разного регистра (a-z, A-Z) и хотя бы один спецсимвол.'
            ],
            [
                'phone',
                'match',
                'pattern' => '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/',
                'message' => 'Поле с номером телефона заполнено неверно.'
            ]
        ];
    }

    /**
     * @param $attr
     */
    public function validateEmail($attr): void
    {
        $user = User::find()->byEmail($this->$attr)->one();
        if (!is_null($user)) {
            $this->addError('email', 'Пользователь с таким email уже существует');
        }
    }

    public function validatePhone($attr): void
    {
        $userProfile = UserProfile::find()->byPhone($this->$attr)->one();
        if (!is_null($userProfile)) {
            $this->addError('phone', 'Пользователь с таким phone уже существует');
        }
    }
}