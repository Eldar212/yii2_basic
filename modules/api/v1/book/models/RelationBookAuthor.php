<?php

namespace app\modules\api\v1\book\models;

use app\modules\api\v1\book\models\query\BookAuthorQuery;
use app\modules\api\v1\book\models\query\BookQuery;
use app\modules\api\v1\book\models\query\RelationBookAuthorQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class RelationBookAuthor extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'relation_book_author';
    }

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
    public function rules(): array
    {
        return [
            [['book_id'], 'required'],
            [['book_id', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['book_id', 'author_id'], 'unique', 'targetAttribute' => ['book_id', 'author_id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookAuthor::class, 'targetAttribute' => ['author_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
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
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery|BookAuthorQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(BookAuthor::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Book]].
     *
     * @return ActiveQuery|BookQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * {@inheritdoc}
     * @return RelationBookAuthorQuery the active query used by this AR class.
     */
    public static function find(): RelationBookAuthorQuery
    {
        return new RelationBookAuthorQuery(get_called_class());
    }
}