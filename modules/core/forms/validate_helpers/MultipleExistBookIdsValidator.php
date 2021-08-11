<?php

namespace app\modules\core\forms\validate_helpers;

use app\modules\api\v1\book\models\Book;

class MultipleExistBookIdsValidator extends MultipleExistIdsValidator
{
    public function init()
    {
        parent::init();

        $this->findModel = Book::class;
        $this->errorMessage = 'Книга c id %diff_ids% не существует';
    }
}