<?php

namespace app\models;

use app\models\query\UserQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id id
 * @property string $email
 * @property string|null $password_hash хэш пароля
 * @property string|null $password_reset_token кен на изменение пароля
 * @property int $status статус
 * @property int|null $created_at дата создания
 * @property int|null $updated_at дата изменения
 */
class User extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_hash'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }

    public static function generatePasswordHash(string $password): string
    {
        return \Yii::$app->security->generatePasswordHash(password);
    }
}
