<?php

namespace app\modules\api\v1\book\models;

use app\modules\api\v1\book\models\behaviors\BookPictureBehavior;
use app\modules\api\v1\book\models\query\BookPictureQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book_picture".
 *
 * @property int $id id
 * @property int $book_id id книги
 * @property UploadedFile|string $path путь к избражению
 * @property int $is_main превью?
 * @property int|null $created_at дата создания
 * @property int|null $updated_at дата изменения
 *
 * @property Book $book
 */
class BookPicture extends ActiveRecord
{
    /** @var int */
    public const IS_MAIN = 1;
    /** @var int */
    public const IS_NOT_MAIN = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book_picture';
    }

    public function behaviors(): array
    {
        return [
            BookPictureBehavior::class,
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['book_id', 'path'], 'required'],
            [['book_id', 'is_main', 'created_at', 'updated_at'], 'integer'],
            [['path'], 'safe'],
            [
                ['book_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Book::class,
                'targetAttribute' => ['book_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'path' => 'Path',
            'is_main' => 'Is Main',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return ActiveQuery
     */
    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * {@inheritdoc}
     * @return BookPictureQuery the active query used by this AR class.
     */
    public static function find(): BookPictureQuery
    {
        return new BookPictureQuery(get_called_class());
    }
}
