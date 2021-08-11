<?php


namespace app\modules\api\v1\profile\models;

use app\modules\api\v1\profile\models\query\UserProfileQuery;
use app\modules\api\v1\user\models\query\UserQuery;
use app\modules\api\v1\user\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property int $user_id ID пользователя
 * @property string $name Имя пользователя
 * @property string $middle_name Фамилия пользователя
 * @property string $last_name Отчество пользователя
 * @property string|null $phone Номер телефона
 * @property int|null $created_at дата создания
 * @property int|null $updated_at дата изменения
 *
 * @property  $user
 */
class UserProfile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user_profile';
    }

    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            TimestampBehavior::class
        ]);
    }

    public function fields(): array
    {
        return [
            'name',
            'middle_name',
            'last_name'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'middle_name', 'last_name'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'middle_name', 'last_name', 'phone'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserProfileQuery(get_called_class());
    }
}