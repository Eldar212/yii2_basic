<?php

namespace app\modules\api\v1\book\forms;

use app\modules\api\v1\book\models\Book;
use app\modules\core\forms\validate_helpers\MultipleExistBookIdsValidator;
use yii\base\Model;


class AuthorAddForm extends Model
{
    /**
     * @var string
     */
    public $first_name;
    /**
     * @var string
     */
    public $middle_name;
    /**
     * @var string
     */
    public $last_name;

    /**
     * @var array
     */
    public $book_ids;

    /**
     * @property Book model
     */

    public function rules(): array
    {
        return
            [
                [['first_name', 'middle_name', 'last_name'], 'required'],
                [['first_name', 'middle_name', 'last_name'], 'trim'],
                [['first_name', 'middle_name', 'last_name'], 'string'],
                ['book_ids', MultipleExistBookIdsValidator::class]
            ];
    }
}