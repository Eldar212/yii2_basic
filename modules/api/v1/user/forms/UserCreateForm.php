<?php


namespace app\modules\api\v1\user\forms;

use app\modules\api\v1\user\models\User;
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
            [['email', 'password', 'name', 'middle_name', 'last_name'], 'required'],
            [['email', 'password', 'name', 'middle_name', 'last_name'], 'string'],
            [['email', 'password', 'name', 'middle_name', 'last_name'], 'trim'],
            [['email'], 'email'],
            ['email', 'validateEmail'],
            [
                'password',
                'match',
                'pattern' => '/^(?=^.{6,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',
                'message' => 'Пароль должен быть не менее 6 символов, а также содержать цифры (0-9), латинские буквы разного регистра (a-z, A-Z) и хотя бы один спецсимвол.'
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
}