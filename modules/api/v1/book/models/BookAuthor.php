<?php

namespace app\modules\api\v1\book\models;

use app\modules\api\v1\book\models\query\BookAuthorQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string first_name [varchar(255)]
 * @property int $id [int]  id автора
 * @property string $middle_name [varchar(255)]  Фамилия
 * @property string $last_name [varchar(255)]  Отчество
 * @property int $created_at [bigint]  дата создания
 * @property int $updated_at [bigint]  дата изменения
 *
 * @property Book[] $books
 */
class BookAuthor extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'book_author';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['first_name', 'middle_name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'first_name',
            'middle_name',
            'last_name',
            'books' => function () {
                return $this->books;
            }
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getRelationBookAuthors(): ActiveQuery
    {
        return $this->hasMany(RelationBookAuthor::class, ['author_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BookAuthorQuery the active query used by this AR class.
     */
    public static function find(): BookAuthorQuery
    {
        return new BookAuthorQuery(get_called_class());
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable(RelationBookAuthor::tableName(), ['author_id' => 'id']);
    }
}