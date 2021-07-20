<?php

    namespace app\models\forms;

    use \app\models\User;

    class UserCreateForm extends User
    {
        /**
         * @var string
         */

        public $email;

        /**
         * @var string
         */

        public $password;

        public function rules()
        {
            return [
                [['email', 'password'], 'required'],
            ];
        }

        public function attributeLabels()
        {
            return [
                'email' => 'Почта',
                'password' => 'Пароль',
            ];
        }

    }