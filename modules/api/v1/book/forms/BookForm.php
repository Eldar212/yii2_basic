<?php

namespace app\modules\api\v1\book\forms;

use app\modules\api\v1\book\models\BookAuthor;
use app\modules\api\v1\book\models\BookPicture;
use app\modules\core\forms\validate_helpers\MultipleExistBookAuthorIdsValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class BookForm extends Model
{
    /** @var string */
    public const SCENARIO_CREATE = 'create';

    /** @var string */
    public const SCENARIO_UPDATE = 'update';

    /** @var string */
    public $name;

    /** @var array */
    public $author_ids;

    /** @var integer */
    public $price;

    /** @var string */
    public $description;

    /** @var UploadedFile */
    public $preview;

    /** @var UploadedFile[] */
    public $pictures;

    public function rules(): array
    {
        return
            [
                [['name', 'price', 'author_ids', 'description', 'preview'], 'required', 'on' => self::SCENARIO_CREATE],
                [['name', 'description'], 'string'],
                [['price'], 'double'],
                ['author_ids', MultipleExistBookAuthorIdsValidator::class],
                [
                    ['preview'],
                    'file',
                    'skipOnEmpty' => true,
                    'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png'],
                    'extensions' => 'png, jpg, jpeg',
                    'maxSize' => 1024 * 1024 * 5 // 5мб
                ],
                [
                    ['pictures'],
                    'file',
                    'skipOnEmpty' => true,
                    'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png'],
                    'extensions' => 'png, jpg, jpeg',
                    'maxFiles' => 4,
                    'maxSize' => 1024 * 1024 * 5 // 5мб
                ],
            ];
    }

    /**
     * @return array
     */
    public function getBookPictures(): array
    {
        $this->preview = [
            'img' => $this->preview,
            'is_main' => BookPicture::IS_MAIN
        ];

        $this->pictures = array_map(function (UploadedFile $picture) {
            return [
                'img' => $picture,
                'is_main' => BookPicture::IS_NOT_MAIN
            ];
        }, $this->pictures);

        return ArrayHelper::merge([$this->preview] , $this->pictures);
    }
}