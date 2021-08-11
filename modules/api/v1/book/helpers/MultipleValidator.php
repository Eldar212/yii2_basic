<?php

namespace  app\modules\api\v1\book\helpers;

use app\modules\api\v1\book\models\Book;
use yii\validators\Validator;

class MultipleValidator
{
    public function validateAttribute($model, $attr)
    {
        $this->$attr = array_unique($this->$attr);
        $authorsIds = $this->$attr;
        $authors = $model::find()->select(['id'])->byId($authorsIds)->column();
        $diff = array_diff($authorsIds, $authors);

        if (!empty($diff)) {
            $diff = implode(', ', $diff);
            $this->addError($attr, "Автор с ID {$diff} не существует");
        }
    }



//    public function authorValidate($attr)
//    {
//        $this->$attr = array_unique($this->$attr);
//        $authorsIds = $this->$attr;
//        $authors = BookAuthor::find()->select(['id'])->byId($authorsIds)->column();
//        $diff = array_diff($authorsIds, $authors);
//
//        if (!empty($diff)) {
//            $diff = implode(', ', $diff);
//            $this->addError($attr, "Автор с ID {$diff} не существует");
//        }
//    }
}