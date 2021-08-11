<?php

namespace app\modules\core\forms\validate_helpers;

use app\modules\api\v1\book\models\BookAuthor;
use yii\db\ActiveRecord;

class MultipleExistBookAuthorIdsValidator extends MultipleExistIdsValidator
{
    public function init()
    {
        parent::init();

        $this->findModel = BookAuthor::class;
        $this->errorMessage = 'Автор c id %diff_ids% не существует';
    }
}