<?php


namespace app\modules\api\v1\book\models\query;


use app\modules\api\v1\book\models\Book;
use yii\db\ActiveQuery;

class BookQuery extends ActiveQuery
{
    public function byId($id): BookQuery
    {
        return $this->andWhere([
            'id' => $id
        ]);
    }

}