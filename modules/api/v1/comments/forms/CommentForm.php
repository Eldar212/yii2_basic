<?php

namespace app\modules\api\v1\comments\forms;

use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\user\models\User;
use yii\base\Model;

class CommentForm extends Model
{
    /**
     * @var integer
     */
    public int $book_id;

    /**
     * @var integer
     */
    public int $comment_author_id;

    /**
     * @var string
     */
    public string $comment_content;

    /**
     * @var string
     */
    public string $comment_title;

    /**
     * @var int
     */
    public int $like_count;

    /**
     * @var int
     */
    public int $dislike_count;


    public function rules(): array
    {
        return [
            [['book_id', 'comment_author_id', 'comment-content'], 'required'],
            [['book_id', 'comment_author_id', 'like_count', 'dislike_count', 'created_at', 'updated_at'], 'integer'],
            [['comment_content'], 'text'],
            [['comment_title'], 'string', 'max' => 60],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['comment_author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['comment_author_id' => 'id']]
        ];
    }
}