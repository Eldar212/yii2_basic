<?php

namespace app\modules\api\v1\book\forms;

use app\modules\api\v1\book\models\BookAuthor;
use app\modules\core\forms\validate_helpers\MultipleExistBookAuthorIdsValidator;
use yii\base\Model;

class BookCreateForm extends Model
{
    /** @var string */
    public $name;

    /** @var integer */
    public $author_ids;

    /** @var integer */
    public $price;

    /** @var string */
    public $description;

    public function rules(): array
    {
        return
        [
            [['name', 'price', 'author_ids', 'description'], 'required'],
            [['name', 'description'], 'string'],
            [['price'], 'double'],
            ['author_ids', MultipleExistBookAuthorIdsValidator::class],
        ];
    }

}