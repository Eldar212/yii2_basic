<?php

namespace app\modules\core\forms\validate_helpers;

use yii\db\ActiveRecord;
use yii\validators\Validator;

abstract class MultipleExistIdsValidator extends Validator
{
    /**
     * @var ActiveRecord
     */
    protected $findModel;

    /**
     * @var string
     */
    protected $errorMessage;
    
    public function validateAttribute($model, $attr)
    {
        $model->$attr = array_unique($model->$attr);
        $valueIds = $model->$attr;
        $findModelIds = $this->findModel::find()->select(['id'])->byId($valueIds)->column();
        $diff = array_diff($valueIds, $findModelIds);

        if (!empty($diff)) {
            $diff = implode(', ', $diff);
            $this->addError($model, $attr, str_replace('%diff_ids%', $diff, $this->errorMessage));
        }
    }
}