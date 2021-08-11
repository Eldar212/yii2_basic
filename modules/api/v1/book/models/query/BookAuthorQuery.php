<?php

namespace app\modules\api\v1\book\models\query;

use yii\db\ActiveQuery;

class BookAuthorQuery extends ActiveQuery
{
    /**
     * @param $id
     * @return BookAuthorQuery
     */
    public function byId($id): BookAuthorQuery
    {
        return $this->andWhere([
            'id' => $id
        ]);
    }
}