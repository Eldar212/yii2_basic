<?php

namespace app\modules\api\v1\book\forms;

use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\book\models\BookAuthor;
use app\modules\api\v1\book\models\RelationBookAuthor;
use yii\base\Model;

class attachEntity extends Model
{
    public $book_id;

    public $author_id;

    public function rules() : array
    {
        return [
            [['book_id', 'author_id'], 'required' ],

        ];
    }
}