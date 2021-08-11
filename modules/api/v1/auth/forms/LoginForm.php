<?php


namespace app\modules\api\v1\auth\forms;


use yii\base\Model;

class LoginForm extends Model
{
    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'email',
            'password' => 'password'
        ];
    }
}