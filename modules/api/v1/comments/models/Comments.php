<?php

namespace app\modules\api\v1\comments\models;

use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\book\models\query\BookQuery;
use app\modules\api\v1\comments\models\query\CommentsQuery;
use app\modules\api\v1\user\models\query\UserQuery;
use app\modules\api\v1\user\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comments".
 *
 * @property int $id id комментария
 * @property int $book_id id книги
 * @property int $comment_author_id id автора комментария
 * @property string $comment_content текст комментария
 * @property string|null $comment_title заголовок комментария
 * @property int|null $like_count количество лайков
 * @property int|null $dislike_count количество дизлайков
 * @property int|null $created_at дата создания
 * @property int|null $updated_at дата изменения
 *
 * @property User $commentAuthor
 * @property Book $book
 */
class Comments extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['book_id', 'comment_author_id', 'comment-content'], 'required'],
            [['book_id', 'comment_author_id', 'like_count', 'dislike_count', 'created_at', 'updated_at'], 'integer'],
            [['comment_content'], 'text'],
            [['comment_title'], 'string', 'max' => 60],
            [['comment_author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['comment_author_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
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
            'comment_author_id' => 'Comment Author ID',
            'comment-content' => 'Comment Content',
            'comment_title' => 'Comment Title',
            'like_count' => 'Like Count',
            'dislike_count' => 'Dislike Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CommentAuthor]].
     *
     * @return ActiveQuery
     */
    public function getCommentAuthor(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'comment_author_id']);
    }

    /**
     * Gets query for [[Book]].
     *
     * @return ActiveQuery
     */
    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    /**
     * {@inheritdoc}
     * @return CommentsQuery the active query used by this AR class.
     */
    public static function find(): CommentsQuery
    {
        return new CommentsQuery(get_called_class());
    }
}
