<?php


namespace app\modules\api\v1\book\models;


use app\modules\api\v1\book\models\query\BookQuery;
use app\modules\api\v1\user\models\User;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id [int]  id
 * @property int $user_id [int]  Добовил в систему
 * @property string $name [varchar(255)]  Название книги
 * @property string $price [decimal(13,2)]  Стоимость книги
 * @property string $description Стоимость книги
 * @property int $created_at [bigint]  дата создания
 * @property int $updated_at [bigint]  дата изменения
 *
 * @property BookAuthor[] $bookAuthors
 * @property BookPicture $preview
 * @property BookPicture[] $pictures
 */
class Book extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'book';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'name',
            'price',
            'description',
//            'authors' => function() {
//                return $this->bookAuthors;
//            },
            'preview' => function () {
                return $this->preview->path;
            },
            'pictures' => function () {
                return array_map(function (BookPicture $picture) {
                    return $picture->path;
                }, $this->pictures);
            },
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['price'], 'number'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'price' => 'Price',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRelationBookAuthors(): ActiveQuery
    {
        return $this->hasMany(RelationBookAuthor::class, ['book_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['id' => 'author_id'])
            ->viaTable(RelationBookAuthor::tableName(), ['book_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPreview(): ActiveQuery
    {
        return $this->hasOne(BookPicture::class, ['book_id' => 'id'])->andWhere(['is_main' => BookPicture::IS_MAIN]);
    }

    public function getPictures(): ActiveQuery
    {
        return $this->hasMany(BookPicture::class, ['book_id' => 'id'])->andWhere(['is_main' => BookPicture::IS_NOT_MAIN]);
    }

    public static function find(): BookQuery
    {
        return new BookQuery(get_called_class());
    }
}