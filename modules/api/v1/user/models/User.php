<?php

namespace app\modules\api\v1\user\models;

use app\modules\api\v1\profile\models\query\UserProfileQuery;
use app\modules\api\v1\user\models\query\UserQuery;
use app\modules\api\v1\profile\models\UserProfile;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\base\Exception;
use yii\db\ActiveQuery;
use Yii;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash хэш пароля
 * @property string|null $password_reset_token токен на изменение пароля
 * @property int $status статус
 * @property string $access_token Токены доступа
 * @property int|null $created_at дата создания
 * @property int|null $updated_at дата изменения
 *
 * @property UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface
{
    /** @var int */
    const STATUS_ACTIVE = 10;

    /** @var int */
    const STATUS_USER_DELETED = 0;

    /** @var int */
    const STATUS_NO_ACTIVE = -1;

    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user';
    }

    public function delete(): string
    {
        return 'delete';
    }

    public function fields(): array
    {
        return [
            'id',
            'email',
            'created_at',
            'updated_at',
            'status',
            'profile' => function () {
                return $this->userProfile;
            }
        ];
    }

    /**
     * @return array
     */
    public function authFields(): array
    {
        return ArrayHelper::merge($this->toArray(), ['access_token' => $this->access_token]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'password_hash'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password_hash', 'password_reset_token', 'access_token'], 'string', 'max' => 255],
            [['email', 'access_token'], 'unique'],
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
            'access_token' => 'Access token',
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

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id): ?IdentityInterface
    {
        return static::findOne($id);
    }


    /**
     * @param string $token
     * @param null $type
     * @return User|IdentityInterface|null
     */

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function generateAccessToken(): bool
    {
        $accessToken = Yii::$app->security->generateRandomString();
        $this->access_token = $accessToken;

        return $this->save();
    }
}