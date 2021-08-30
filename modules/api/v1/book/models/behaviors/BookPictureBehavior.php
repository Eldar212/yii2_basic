<?php

namespace app\modules\api\v1\book\models\behaviors;

use app\modules\api\v1\book\models\BookPicture;
use app\modules\core\helpers\FileHelper;
use Yii;
use yii\base\Behavior;
use yii\base\Exception;
use yii\db\BaseActiveRecord;
use yii\web\UploadedFile;

class BookPictureBehavior extends Behavior
{
    /**
     * @return string[]
     */
    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',

        ];
    }

    /**
     * @throws Exception
     */
    public function beforeInsert(): void
    {
        /** @var BookPicture $bookPicture */
        $bookPicture = $this->owner;

        if ($bookPicture->path instanceof UploadedFile) {
            $pictureName = FileHelper::getRandName();
            $pictureFolder = $bookPicture->is_main ? 'preview' : 'picture';

            $basePathPicture = "uploads/book/{$pictureFolder}/{$pictureName}.{$bookPicture->path->getExtension()}";
            $bookPicture->path->saveAs("@webroot/{$basePathPicture}");
            $bookPicture->path = $basePathPicture;
        }
    }

    public function afterDelete(): void
    {
        /** @var BookPicture $bookPicture */
        $bookPicture = $this->owner;
        $bookPicturePath = Yii::getAlias("@webroot/{$bookPicture->path}");

        if (file_exists($bookPicturePath)) {
            unlink($bookPicturePath);
        }
    }
}