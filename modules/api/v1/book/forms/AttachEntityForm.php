<?php

namespace app\modules\api\v1\book\forms;

use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\book\models\BookAuthor;
use yii\base\Model;

class AttachEntityForm extends Model
{
    /** @var integer */
    public $book_id;

    /** @var integer */
    public $author_id;

    public function rules(): array
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookAuthor::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }
}