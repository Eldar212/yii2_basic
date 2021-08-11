<?php

namespace app\modules\api\v1\book\models\query;

use yii\db\ActiveQuery;

class RelationBookAuthorQuery extends ActiveQuery
{
    public function byAuthor($authorId)
    {
        return $this->andWhere([
            'author_id' => $authorId
        ]);
    }

    public function byBook($bookId)
    {
        return $this->andWhere([
            'book_id' => $bookId
        ]);
    }
}