<?php
namespace app\modules\api\v1\user\models;

use app\modules\api\v1\profile\models\query\UserProfileQuery;
use app\modules\api\v1\profile\models\UserProfile;
use app\modules\api\v1\user\models\query\UserQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash хэш пароля
 * @property string|null $password_reset_token токен на изменение пароля
 * @property int $status статус
 * @property int|null $created_at дата создания
 * @property int|null $updated_at дата изменения
 *
 * @property UserProfile $userProfile
 */
class User extends ActiveRecord
{
    /** @var int */
    const STATUS_ACTIVE = 10;

    /** @var int */
    const STATUS_NO_ACTIVE = -1;

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
            [['email', 'password_hash'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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
     * Gets query for [[UserProfile]].
     *
     * @return ActiveQuery|UserProfileQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }
}